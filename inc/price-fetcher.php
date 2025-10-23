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