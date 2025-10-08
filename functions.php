<?php
/**
 * Banker Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function banker_theme_setup() {
    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Add theme support for post thumbnails
    add_theme_support('post-thumbnails');
    
    // Add theme support for title tag
    add_theme_support('title-tag');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'banker'),
        'desktop' => __('Desktop Menu', 'banker'),
    ));
}
add_action('after_setup_theme', 'banker_theme_setup');

/**
 * Persian Date Function
 * Compatible with Persian date plugins like WP Parsidate
 */
function banker_get_persian_date($format = 'l j F Y') {
    // Check if Persian date functions are available
    if (function_exists('parsidate')) {
        // WP Parsidate plugin
        return parsidate($format, current_time('timestamp'));
    } else {
        // Fallback to manual Persian date conversion
        return banker_manual_persian_date($format);
    }
}

/**
 * Manual Persian Date Conversion (Fallback)
 */
function banker_manual_persian_date($format = 'l j F Y') {
    $persian_months = array(
        1 => 'فروردین', 2 => 'اردیبهشت', 3 => 'خرداد',
        4 => 'تیر', 5 => 'مرداد', 6 => 'شهریور',
        7 => 'مهر', 8 => 'آبان', 9 => 'آذر',
        10 => 'دی', 11 => 'بهمن', 12 => 'اسفند'
    );
    
    $persian_days = array(
        'Saturday' => 'شنبه',
        'Sunday' => 'یکشنبه',
        'Monday' => 'دوشنبه',
        'Tuesday' => 'سه‌شنبه',
        'Wednesday' => 'چهارشنبه',
        'Thursday' => 'پنج‌شنبه',
        'Friday' => 'جمعه'
    );
    
    // Simple conversion for demonstration
    // In production, you should use a proper Jalali calendar library
    $current_date = current_time('timestamp');
    $day_name = $persian_days[date('l', $current_date)] ?? date('l', $current_date);
    
    // For now, return a sample Persian date format
    // This should be replaced with proper Jalali conversion
    return $day_name . ' ۲۰ شهریور ۱۴۰۴';
}

/**
 * Include Customizer Files
 */
require_once get_template_directory() . '/inc/customizer/homepage-customizer.php';
require_once get_template_directory() . '/inc/customizer/homepage-helpers.php';

/**
 * Customizer Settings
 */
function banker_customize_register($wp_customize) {
    
    // Social Media Section
    $wp_customize->add_section('banker_social_media', array(
        'title'    => __('شبکه‌های اجتماعی', 'banker'),
        'priority' => 30,
    ));
    
    // Phone Number
    $wp_customize->add_setting('banker_phone', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('banker_phone', array(
        'label'    => __('شماره تلفن', 'banker'),
        'section'  => 'banker_social_media',
        'type'     => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('banker_email', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('banker_email', array(
        'label'    => __('ایمیل', 'banker'),
        'section'  => 'banker_social_media',
        'type'     => 'email',
    ));
    
    // Twitter/X
    $wp_customize->add_setting('banker_twitter', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('banker_twitter', array(
        'label'    => __('لینک توییتر/X', 'banker'),
        'section'  => 'banker_social_media',
        'type'     => 'url',
    ));
    
    // Telegram
    $wp_customize->add_setting('banker_telegram', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('banker_telegram', array(
        'label'    => __('لینک تلگرام', 'banker'),
        'section'  => 'banker_social_media',
        'type'     => 'url',
    ));
    
    // RSS Feed
    $wp_customize->add_setting('banker_rss', array(
        'default'           => get_bloginfo('rss2_url'),
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('banker_rss', array(
        'label'    => __('لینک RSS', 'banker'),
        'section'  => 'banker_social_media',
        'type'     => 'url',
    ));
}
add_action('customize_register', 'banker_customize_register');

/**
 * Enqueue Styles and Scripts
 */
function banker_enqueue_assets() {
    // Enqueue main stylesheet
    wp_enqueue_style('banker-style', get_template_directory_uri() . '/assets/css/output.css', array(), '1.0.0');
    
    // Enqueue custom JavaScript if needed
    wp_enqueue_script('banker-script', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'banker_enqueue_assets');

/**
 * Get Social Media Links
 */
function banker_get_social_links() {
    return array(
        'phone' => get_theme_mod('banker_phone', ''),
        'email' => get_theme_mod('banker_email', ''),
        'twitter' => get_theme_mod('banker_twitter', ''),
        'telegram' => get_theme_mod('banker_telegram', ''),
        'rss' => get_theme_mod('banker_rss', get_bloginfo('rss2_url')),
    );
}

/**
 * Get Custom Logo URL
 */
function banker_get_logo_url() {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        return $logo_url;
    }
    // Default logo path
    return get_template_directory_uri() . '/assets/images/logo.png';
}

// Custom Walker for Desktop Menu
class Banker_Desktop_Walker extends Walker_Nav_Menu {
    
    // Start Level - wrapper for the sub menu
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"hidden group-hover:flex flex-col absolute right-0 top-full bg-white shadow-lg rounded-md md:border md:border-gray-100 min-w-[160px] z-50\">\n";
    }

    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    // Start Element - each menu item
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        if ($depth == 0) {
            // Top level items with border styling like original
            $class_names = 'relative group';
            
            // Check if item has children for dropdown
            $has_children = in_array('menu-item-has-children', $classes);
            
            if ($has_children) {
                $link_class = 'hover:text-secondary border-l pl-4 border-border flex gap-2 justify-between items-center w-full text-right md:border-l md:pl-4 md:border-border';
            } else {
                $link_class = 'hover:text-secondary border-l pl-4 border-border';
            }
        } else {
            // Sub menu items - no li wrapper for submenu
            $link_class = 'px-4 py-2 text-sm hover:bg-blue-50';
        }

        if ($depth == 0) {
            $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args);
            $id = $id ? ' id="' . esc_attr($id) . '"' : '';
            $output .= $indent . '<li' . $id . ' class="' . esc_attr($class_names) . '">';
        }

        $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
        $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
        $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';

        $item_output = isset($args->before) ? $args->before : '';
        
        if ($depth == 0 && in_array('menu-item-has-children', $classes)) {
            // For dropdown items, use button instead of link
            $item_output .= '<button class="' . esc_attr($link_class) . '">';
            $item_output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
            $item_output .= '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 transition-transform duration-300 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>';
            $item_output .= '</button>';
        } else {
            $item_output .= '<a class="' . esc_attr($link_class) . '"' . $attributes .'>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
        }
        
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        if ($depth == 0) {
            $output .= "</li>\n";
        }
    }
}