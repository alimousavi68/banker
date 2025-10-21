<?php
/**
 * Server-side price fetcher: fetch XML prices and store JSON in uploads.
 */

if (!defined('ABSPATH')) {
    exit;
}

// Fallback define for API token (prefer moving to wp-config.php)
if (!defined('BANKER_PRICE_API_TOKEN')) {
    define('BANKER_PRICE_API_TOKEN', 'bo2fmBJhQlBEww7XaJ1EKaqeijnKpbM53R4Xl_Ufd_c=');
}

function banker_price_ticker_paths() {
    $upload = wp_upload_dir();
    $dir = trailingslashit($upload['basedir']) . 'ticker';
    $file = $dir . '/price-ticker.json';
    $tmp = $dir . '/price-ticker.tmp';
    $url  = trailingslashit($upload['baseurl']) . 'ticker/price-ticker.json';
    return compact('dir', 'file', 'tmp', 'url');
}

function banker_parse_currency_xml($xml_string) {
    $result = [];
    if (!$xml_string) return $result;
    $xml = @simplexml_load_string($xml_string);
    if (!$xml) return $result;
    $nodes = isset($xml->prices) ? $xml->prices->currency : $xml->currency;
    foreach ($nodes as $currency) {
        $symbol = (string) $currency['symbol'];
        $current = (string) $currency->current;
        if ($symbol !== '' && $current !== '') {
            $result[$symbol] = (int) $current;
        }
    }
    return $result;
}

function banker_parse_gold_xml($xml_string) {
    $result = [];
    if (!$xml_string) return $result;
    libxml_use_internal_errors(true);
    $xml = @simplexml_load_string($xml_string);
    if (!$xml) return $result;
    $nodes = $xml->xpath('//prices/gold');
    if ($nodes === false) return $result;
    foreach ($nodes as $gold) {
        $symbol = (string) $gold['symbol'];
        $current = (string) $gold->current;
        if ($symbol !== '' && $current !== '') {
            $result[$symbol] = (int) $current;
        }
    }
    return $result;
}

function banker_parse_crypto_xml($xml_string) {
    $result = [];
    if (!$xml_string) return $result;
    $xml = @simplexml_load_string($xml_string);
    if (!$xml) return $result;
    $nodes = isset($xml->prices) ? $xml->prices->crypto : $xml->crypto;
    foreach ($nodes as $crypto) {
        $symbol = (string) $crypto['symbol'];
        $current = (string) $crypto->current;
        if ($symbol !== '' && $current !== '') {
            $result[$symbol] = (int) $current;
        }
    }
    return $result;
}

function banker_fetch_prices_and_store_json() {
    $headers = [
        'Authorization' => 'Bearer ' . BANKER_PRICE_API_TOKEN,
        'Accept'        => 'application/xml',
    ];
    $base = 'https://api.nerkh.io/v1/prices/xml';

    $args = [
        'headers' => $headers,
        'timeout' => 15,
    ];

    $currency_resp = wp_remote_get("{$base}/currency", $args);
    $gold_resp     = wp_remote_get("{$base}/gold", $args);
    $crypto_resp   = wp_remote_get("{$base}/crypto", $args);

    // Basic error handling and rate-limit awareness
    foreach ([$currency_resp, $gold_resp, $crypto_resp] as $resp) {
        if (is_wp_error($resp)) {
            error_log('[banker] price fetch error: ' . $resp->get_error_message());
            return false;
        }
        $code = wp_remote_retrieve_response_code($resp);
        if ($code === 429) {
            error_log('[banker] price fetch rate limited (429)');
            return false; // keep last good JSON
        }
        if ($code < 200 || $code >= 300) {
            error_log('[banker] price fetch http status: ' . $code);
            return false;
        }
    }

    $currency_xml = wp_remote_retrieve_body($currency_resp);
    $gold_xml     = wp_remote_retrieve_body($gold_resp);
    $crypto_xml   = wp_remote_retrieve_body($crypto_resp);

    $currency = banker_parse_currency_xml($currency_xml);
    $gold     = banker_parse_gold_xml($gold_xml);
    $crypto   = banker_parse_crypto_xml($crypto_xml);

    $payload = [
        'currency'   => $currency,
        'gold'       => $gold,
        'crypto'     => $crypto,
        'updated_at' => gmdate('c'),
    ];

    $paths = banker_price_ticker_paths();
    wp_mkdir_p($paths['dir']);
    $json = wp_json_encode($payload);
    if ($json === false) {
        error_log('[banker] json encode failed');
        return false;
    }

    // Write safely via temp file then atomic rename
    if (@file_put_contents($paths['tmp'], $json) === false) {
        error_log('[banker] writing temp file failed: ' . $paths['tmp']);
        return false;
    }
    if (!@rename($paths['tmp'], $paths['file'])) {
        error_log('[banker] atomic rename failed');
        return false;
    }

    return true;
}

// Add 1-minute cron schedule
add_filter('cron_schedules', function ($schedules) {
    if (!isset($schedules['every_minute'])) {
        $schedules['every_minute'] = [
            'interval' => 60,
            'display'  => __('Every Minute', 'banker'),
        ];
    }
    return $schedules;
});

// Schedule event if not already
add_action('init', function () {
    if (!wp_next_scheduled('banker_fetch_prices_event')) {
        wp_schedule_event(time(), 'every_minute', 'banker_fetch_prices_event');
    }
});

// Hook the event to our fetcher
add_action('banker_fetch_prices_event', 'banker_fetch_prices_and_store_json');

// Prime or refresh JSON if missing/stale when a page loads
function banker_maybe_prime_price_json() {
    $paths = banker_price_ticker_paths();
    $max_age = 120; // seconds
    if (!file_exists($paths['file'])) {
        banker_fetch_prices_and_store_json();
        return;
    }
    $age = time() - @filemtime($paths['file']);
    if ($age > $max_age) {
        banker_fetch_prices_and_store_json();
    }
}
add_action('init', 'banker_maybe_prime_price_json');

// =============================
// REST endpoint for server cron
// =============================
// Optional token for REST refresh; set a secure value in wp-config.php
if (!defined('BANKER_PRICE_CRON_TOKEN')) {
    define('BANKER_PRICE_CRON_TOKEN', 'changeme');
}

function banker_verify_cron_token_from_request($request) {
    $param  = method_exists($request, 'get_param') ? $request->get_param('token') : null;
    $header = method_exists($request, 'get_header') ? $request->get_header('X-Banker-Token') : null;
    $token  = $param ?: $header;
    if (!defined('BANKER_PRICE_CRON_TOKEN') || BANKER_PRICE_CRON_TOKEN === 'changeme') {
        return false;
    }
    return is_string($token) && hash_equals(BANKER_PRICE_CRON_TOKEN, $token);
}

add_action('rest_api_init', function() {
    register_rest_route('banker/v1', '/refresh-prices', [
        'methods'  => 'GET',
        'permission_callback' => function () { return true; },
        'callback' => function ($request) {
            if (!banker_verify_cron_token_from_request($request)) {
                return new WP_Error('forbidden', 'Invalid token', ['status' => 403]);
            }
            $ok = banker_fetch_prices_and_store_json();
            $paths = banker_price_ticker_paths();
            return [
                'ok'         => (bool) $ok,
                'file'       => $paths['url'],
                'updated_at' => gmdate('c'),
            ];
        },
    ]);
});

// ==================================
// Admin-side triggers with lock/TTL
// ==================================
function banker_price_lock_acquire($ttl = 60) {
    if (get_transient('banker_price_lock')) {
        return false;
    }
    set_transient('banker_price_lock', 1, $ttl);
    return true;
}

function banker_maybe_refresh_prices_with_lock($max_age = 120, $reason = 'trigger') {
    $paths = banker_price_ticker_paths();
    $age = file_exists($paths['file']) ? time() - @filemtime($paths['file']) : PHP_INT_MAX;
    if ($age <= $max_age) {
        return false;
    }
    if (!banker_price_lock_acquire()) {
        return false;
    }
    error_log('[banker] refreshing prices via ' . $reason);
    return banker_fetch_prices_and_store_json();
}

// Trigger on saving posts (moderate frequency)
add_action('save_post', function($post_id, $post, $update) {
    if (wp_is_post_revision($post_id)) return;
    banker_maybe_refresh_prices_with_lock(150, 'save_post');
}, 10, 3);

// Light check on admin_init (less frequent, gated by TTL/lock)
add_action('admin_init', function() {
    banker_maybe_refresh_prices_with_lock(180, 'admin_init');
});

// =============================
// WP-CLI command for server cron
// =============================
if (defined('WP_CLI') && class_exists('WP_CLI')) {
    WP_CLI::add_command('banker refresh-prices', function() {
        $ok = banker_fetch_prices_and_store_json();
        if ($ok) {
            WP_CLI::success('Prices refreshed.');
        } else {
            WP_CLI::error('Refresh failed.');
        }
    });
}