<?php
/**
 * Post Settings Helper Functions
 * 
 * Helper functions to retrieve and process post settings
 * 
 * @package Banker
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get Post Prefix Settings
 */
function banker_get_post_prefix_settings() {
    return array(
        'enable' => get_theme_mod('banker_post_prefix_enable', false),
        'content' => get_theme_mod('banker_post_prefix_content', 'به گزارش پایگاه خبری بنکر، '),
    );
}

/**
 * Get Post Suffix Settings
 */
function banker_get_post_suffix_settings() {
    return array(
        'enable' => get_theme_mod('banker_post_suffix_enable', false),
        'content' => get_theme_mod('banker_post_suffix_content', ''),
    );
}

/**
 * Get Related Inline Settings
 */
function banker_get_related_inline_settings() {
    return array(
        'enable'   => get_theme_mod('banker_related_inline_enable', false),
        'count'    => absint(get_theme_mod('banker_related_inline_count', 3)),
        'position' => get_theme_mod('banker_related_inline_position', 'post_middle'),
        'title'    => get_theme_mod('banker_related_inline_title', 'مطالب مرتبط'),
    );
}

/**
 * Sanitize Related Inline Position
 */
function banker_sanitize_related_inline_position($value) {
    $allowed = array('paragraph_1','paragraph_2','paragraph_3','post_middle','post_end');
    return in_array($value, $allowed, true) ? $value : 'post_middle';
}

/**
 * Get Advertisement Settings
 */
function banker_get_advertisement_settings() {
    $ads_enable = get_theme_mod('banker_ads_enable', false);
    
    if (!$ads_enable) {
        return array();
    }
    
    $ads = array();
    
    for ($i = 1; $i <= 10; $i++) {
        if (get_theme_mod("banker_ad_{$i}_enable", false)) {
            $code = get_theme_mod("banker_ad_{$i}_code", '');
            $position = get_theme_mod("banker_ad_{$i}_position", 'post_start');
            
            if (!empty($code)) {
                $ads[] = array(
                    'id' => $i,
                    'code' => $code,
                    'position' => $position,
                );
            }
        }
    }
    
    return $ads;
}

/**
 * Insert default prefix into editor for new posts
 */
function banker_default_content_prefix($content, $post) {
    if ($post instanceof WP_Post && $post->post_type === 'post') {
        $prefix = banker_get_post_prefix_settings();
        if (!empty($prefix['content']) && !empty($prefix['enable'])) {
            // Prepend the configured prefix to the editor default content
            $content = wp_kses_post($prefix['content']) . "\n\n" . $content;
        }
    }
    return $content;
}
add_filter('default_content', 'banker_default_content_prefix', 10, 2);

/**
 * Process Post Content with Suffix, Ads and Related Inline
 */
function banker_process_post_content($content) {
    // Only process on single post pages and when viewing posts (not in admin)
    if (!is_single() || is_admin()) {
        return $content;
    }
    
    $processed_content = $content;
    
    // NOTE: Prefix injection removed. Prefix is now inserted only as default editor content on new posts.
    
    // Add suffix text
    $suffix_settings = banker_get_post_suffix_settings();
    if ($suffix_settings['enable'] && !empty($suffix_settings['content'])) {
        $processed_content = $processed_content . '<div class="banker-post-suffix">' . wp_kses_post($suffix_settings['content']) . '</div>';
    }
    
    // Process advertisements
    $ads = banker_get_advertisement_settings();
    if (!empty($ads)) {
        $processed_content = banker_insert_ads_in_content($processed_content, $ads);
    }

    // Insert related inline content (if enabled)
    $related = banker_get_related_inline_settings();
    if (!empty($related['enable'])) {
        $processed_content = banker_insert_related_inline_content($processed_content, $related);
    }
    
    return $processed_content;
}

/**
 * Insert Advertisements in Content
 */
function banker_insert_ads_in_content($content, $ads) {
    // Split content into paragraphs
    $paragraphs = preg_split('/(<p[^>]*>.*?<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    
    $processed_content = '';
    $paragraph_count = 0;
    
    // Count actual paragraphs (not empty elements)
    $actual_paragraphs = array_filter($paragraphs, function($p) {
        return preg_match('/<p[^>]*>/i', $p);
    });
    $total_paragraphs = count($actual_paragraphs);
    
    // Calculate middle position (ensure it's at least 2 and not more than total-1)
    $middle_position = max(2, min($total_paragraphs - 1, ceil($total_paragraphs / 2)));
    
    foreach ($paragraphs as $paragraph) {
        // Check if this is a paragraph tag
        if (preg_match('/<p[^>]*>/i', $paragraph)) {
            $paragraph_count++;
            
            // Add post_start ads before first paragraph
            if ($paragraph_count === 1) {
                foreach ($ads as $ad) {
                    if ($ad['position'] === 'post_start') {
                        $processed_content .= '<div class="banker-ad banker-ad-post-start">' . $ad['code'] . '</div>';
                    }
                }
            }
            
            // Add paragraph
            $processed_content .= $paragraph;
            
            // Add ads after specific paragraphs
            foreach ($ads as $ad) {
                switch ($ad['position']) {
                    case 'paragraph_1':
                        if ($paragraph_count === 1) {
                            $processed_content .= '<div class="banker-ad banker-ad-paragraph-1">' . $ad['code'] . '</div>';
                        }
                        break;
                        
                    case 'paragraph_2':
                        if ($paragraph_count === 2) {
                            $processed_content .= '<div class="banker-ad banker-ad-paragraph-2">' . $ad['code'] . '</div>';
                        }
                        break;
                        
                    case 'paragraph_3':
                        if ($paragraph_count === 3) {
                            $processed_content .= '<div class="banker-ad banker-ad-paragraph-3">' . $ad['code'] . '</div>';
                        }
                        break;
                        
                    case 'post_middle':
                        if ($paragraph_count === $middle_position && $total_paragraphs > 2) {
                            $processed_content .= '<div class="banker-ad banker-ad-post-middle">' . $ad['code'] . '</div>';
                        }
                        break;
                }
            }
        } else {
            // Add non-paragraph content as is
            $processed_content .= $paragraph;
        }
    }
    
    // Add post_end ads
    foreach ($ads as $ad) {
        if ($ad['position'] === 'post_end') {
            $processed_content .= '<div class="banker-ad banker-ad-post-end">' . $ad['code'] . '</div>';
        }
    }
    
    return $processed_content;
}

/**
 * Insert Related Inline Content
 */
function banker_insert_related_inline_content($content, $settings) {
    // Build related posts markup
    global $post;
    if (!($post instanceof WP_Post)) {
        return $content;
    }

    // Query related posts by categories
    $cats = wp_get_post_categories($post->ID);
    $q = new WP_Query(array(
        'post_type'      => 'post',
        'posts_per_page' => max(1, absint($settings['count'])),
        'post__not_in'   => array($post->ID),
        'category__in'   => !empty($cats) ? $cats : array(),
        'ignore_sticky_posts' => true,
        'no_found_rows'  => true,
    ));

    if (!$q->have_posts()) {
        return $content;
    }

    $items = '';
    while ($q->have_posts()) { $q->the_post();
        $items .= '<li><a href="' . esc_url(get_permalink()) . '" title="' . esc_attr(get_the_title()) . '">' . esc_html(get_the_title()) . '</a></li>';
    }
    wp_reset_postdata();

    $related_html = '<div class="banker-related-inline">'
        . '<div class="related-title">' . esc_html($settings['title']) . '</div>'
        . '<ul class="related-list">' . $items . '</ul>'
        . '</div>';

    // Insert after target position
    $paragraphs = preg_split('/(<p[^>]*>.*?<\/p>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $processed = '';
    $pcount = 0;
    $actual_paragraphs = array_filter($paragraphs, function($p){ return preg_match('/<p[^>]*>/i', $p); });
    $total = count($actual_paragraphs);
    $middle = max(2, min($total - 1, ceil($total / 2)));

    foreach ($paragraphs as $p) {
        if (preg_match('/<p[^>]*>/i', $p)) {
            $pcount++;
            $processed .= $p;
            switch ($settings['position']) {
                case 'paragraph_1':
                    if ($pcount === 1) { $processed .= $related_html; }
                    break;
                case 'paragraph_2':
                    if ($pcount === 2) { $processed .= $related_html; }
                    break;
                case 'paragraph_3':
                    if ($pcount === 3) { $processed .= $related_html; }
                    break;
                case 'post_middle':
                    if ($pcount === $middle && $total > 2) { $processed .= $related_html; }
                    break;
            }
        } else {
            $processed .= $p;
        }
    }

    if ($settings['position'] === 'post_end') {
        $processed .= $related_html;
    }

    return $processed;
}

/**
 * Add Custom CSS for Post Settings
 */
function banker_post_settings_custom_css() {
    ?>
    <style>
    .banker-post-prefix {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
        font-size: 1.1em;
    }
    
    .banker-post-suffix {
        margin-top: 2rem;
        padding: 1rem 1rem 1rem 1rem;
        background-color: #f8fafc;
        border-radius: 0; /* exact 0px per request */
        position: relative;
    }
    .banker-post-suffix::before {
        content: "";
        position: absolute;
        right: 0;
        top: .5rem; /* reduce vertical accent height */
        bottom: .5rem;
        width: 4px;
        background-color: var(--color-secondary);
        border-radius: 0;
    }
    
    .banker-ad {
        margin: 1.5rem 0;
        text-align: center;
        clear: both;
    }
    
    .banker-ad-post-start {
        margin-top: 0;
        margin-bottom: 2rem;
    }
    
    .banker-ad-post-end {
        margin-top: 2rem;
        margin-bottom: 0;
    }
    
    .banker-ad-post-middle {
        margin: 2rem 0;
        padding: 1rem 0;
        border-top: 1px solid #e5e7eb;
        border-bottom: 1px solid #e5e7eb;
    }

    /* Related inline block - minimalist & pastel style */
    .banker-related-inline {
        margin: 1.5rem 0;
        padding: 1rem;
        background: #fff7f7; /* soft pastel background */
        border-right: 4px solid var(--color-secondary);
        border-radius: 0;
    }
    .banker-related-inline .related-title {
        font-weight: 700;
        margin-bottom: .75rem;
        color: var(--color-secondary);
        font-size: 1rem;
    }
    .banker-related-inline .related-list {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        gap: .5rem .75rem;
        margin: 0;
        padding: 0;
    }
    .banker-related-inline .related-list li {
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 8px;
        padding: .35rem .6rem;
    }
    .banker-related-inline .related-list a {
        color: #374151;
        text-decoration: none;
    }
    .banker-related-inline .related-list a:hover {
        color: var(--color-primary);
    }
    
    @media (max-width: 768px) {
        .banker-ad {
            margin: 1rem 0;
        }
        
        .banker-post-suffix {
            padding: 0.75rem;
            font-size: 0.9em;
        }
    }
    </style>
    <?php
}

// Hook the content filter
add_filter('the_content', 'banker_process_post_content', 20);

// Add custom CSS
add_action('wp_head', 'banker_post_settings_custom_css');