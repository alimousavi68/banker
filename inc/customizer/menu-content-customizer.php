<?php
/**
 * Menu Content Customizer Settings
 * 
 * This file contains all customizer settings for menu content management
 * 
 * @package Banker
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Menu Content Customizer Settings
 */
function banker_menu_content_customize_register($wp_customize) {
    
    // Add Menu Content Panel
    $wp_customize->add_panel('banker_menu_content_panel', array(
        'title'       => __('مدیریت محتوای منو', 'banker'),
        'description' => __('تنظیمات مربوط به محتوای منو، معرفی، شبکه‌های اجتماعی و فوتر', 'banker'),
        'priority'    => 25,
    ));

    // ========================================
    // Intro Section Settings
    // ========================================
    $wp_customize->add_section('banker_intro_section', array(
        'title'    => __('بخش معرفی کوتاه', 'banker'),
        'panel'    => 'banker_menu_content_panel',
        'priority' => 10,
    ));

    // Intro Logo
    $wp_customize->add_setting('banker_intro_logo', array(
        'default'           => get_template_directory_uri() . '/assets/images/logoBanker.png',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'banker_intro_logo', array(
        'label'    => __('لوگو بخش معرفی', 'banker'),
        'section'  => 'banker_intro_section',
        'settings' => 'banker_intro_logo',
    )));

    // Intro Text
    $wp_customize->add_setting('banker_intro_text', array(
        'default'           => 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_intro_text', array(
        'label'   => __('متن معرفی', 'banker'),
        'section' => 'banker_intro_section',
        'type'    => 'textarea',
        'input_attrs' => array(
            'rows' => 4,
        ),
    ));

    // ========================================
    // Enhanced Social Media Section
    // ========================================
    $wp_customize->add_section('banker_enhanced_social_media', array(
        'title'    => __('شبکه‌های اجتماعی (مرکزی)', 'banker'),
        'panel'    => 'banker_menu_content_panel',
        'priority' => 20,
        'description' => __('این تنظیمات در topbar هدر و بخش معرفی فوتر استفاده می‌شود', 'banker'),
    ));
    
    // Phone Number
    $wp_customize->add_setting('banker_enhanced_phone', array(
        'default'           => get_theme_mod('banker_phone', ''),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('banker_enhanced_phone', array(
        'label'    => __('شماره تلفن', 'banker'),
        'section'  => 'banker_enhanced_social_media',
        'type'     => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('banker_enhanced_email', array(
        'default'           => get_theme_mod('banker_email', ''),
        'sanitize_callback' => 'sanitize_email',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('banker_enhanced_email', array(
        'label'    => __('ایمیل', 'banker'),
        'section'  => 'banker_enhanced_social_media',
        'type'     => 'email',
    ));
    
    // Twitter/X
    $wp_customize->add_setting('banker_enhanced_twitter', array(
        'default'           => get_theme_mod('banker_twitter', ''),
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('banker_enhanced_twitter', array(
        'label'    => __('لینک توییتر/X', 'banker'),
        'section'  => 'banker_enhanced_social_media',
        'type'     => 'url',
    ));
    
    // Telegram
    $wp_customize->add_setting('banker_enhanced_telegram', array(
        'default'           => get_theme_mod('banker_telegram', ''),
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('banker_enhanced_telegram', array(
        'label'    => __('لینک تلگرام', 'banker'),
        'section'  => 'banker_enhanced_social_media',
        'type'     => 'url',
    ));
    
    // RSS Feed
    $wp_customize->add_setting('banker_enhanced_rss', array(
        'default'           => get_theme_mod('banker_rss', get_bloginfo('rss2_url')),
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('banker_enhanced_rss', array(
        'label'    => __('لینک RSS', 'banker'),
        'section'  => 'banker_enhanced_social_media',
        'type'     => 'url',
    ));

    // ========================================
    // Footer Menu Section
    // ========================================
    $wp_customize->add_section('banker_footer_menu_section', array(
        'title'    => __('منوی فوتر', 'banker'),
        'panel'    => 'banker_menu_content_panel',
        'priority' => 30,
    ));

    // Footer Menu Selection
    $wp_customize->add_setting('banker_footer_menu', array(
        'default'           => '',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_footer_menu', array(
        'label'    => __('انتخاب منو برای "مروری بر دسته‌بندی اخبار"', 'banker'),
        'section'  => 'banker_footer_menu_section',
        'type'     => 'select',
        'choices'  => banker_get_menu_choices(),
    ));

    // Footer Menu Title
    $wp_customize->add_setting('banker_footer_menu_title', array(
        'default'           => 'مروری بر دسته بندی اخبار',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_footer_menu_title', array(
        'label'   => __('عنوان بخش منوی فوتر', 'banker'),
        'section' => 'banker_footer_menu_section',
        'type'    => 'text',
    ));

    // ========================================
    // Copyright Section
    // ========================================
    $wp_customize->add_section('banker_copyright_section', array(
        'title'    => __('کپی‌رایت', 'banker'),
        'panel'    => 'banker_menu_content_panel',
        'priority' => 40,
    ));

    // Copyright Text
    $wp_customize->add_setting('banker_copyright_text', array(
        'default'           => 'نقل و نشر مطالب با ذکر نام بنکر به مطالب بلامانع است. کلیه حقوق مادی و معنوی متعلق به بانکداران ۲۴ می باشد',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_copyright_text', array(
        'label'   => __('متن کپی‌رایت', 'banker'),
        'section' => 'banker_copyright_section',
        'type'    => 'textarea',
        'input_attrs' => array(
            'rows' => 3,
        ),
    ));
}
add_action('customize_register', 'banker_menu_content_customize_register');

/**
 * Get Menu Choices for Customizer
 */
function banker_get_menu_choices() {
    $menus = wp_get_nav_menus();
    $choices = array(
        '' => __('انتخاب منو...', 'banker'),
    );
    
    foreach ($menus as $menu) {
        $choices[$menu->term_id] = $menu->name;
    }
    
    return $choices;
}

/**
 * Get Enhanced Social Media Links
 */
function banker_get_enhanced_social_links() {
    return array(
        'phone' => get_theme_mod('banker_enhanced_phone', get_theme_mod('banker_phone', '')),
        'email' => get_theme_mod('banker_enhanced_email', get_theme_mod('banker_email', '')),
        'twitter' => get_theme_mod('banker_enhanced_twitter', get_theme_mod('banker_twitter', '')),
        'telegram' => get_theme_mod('banker_enhanced_telegram', get_theme_mod('banker_telegram', '')),
        'rss' => get_theme_mod('banker_enhanced_rss', get_theme_mod('banker_rss', get_bloginfo('rss2_url'))),
    );
}

/**
 * Get Intro Section Settings
 */
function banker_get_intro_section_settings() {
    return array(
        'logo' => get_theme_mod('banker_intro_logo', get_template_directory_uri() . '/assets/images/logoBanker.png'),
        'text' => get_theme_mod('banker_intro_text', 'لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است چاپگرها و متون بلکه روزنامه و مجله'),
    );
}

/**
 * Get Footer Menu Settings
 */
function banker_get_footer_menu_settings() {
    return array(
        'menu_id' => get_theme_mod('banker_footer_menu', ''),
        'title' => get_theme_mod('banker_footer_menu_title', 'مروری بر دسته بندی اخبار'),
    );
}

/**
 * Get Copyright Text
 */
function banker_get_copyright_text() {
    return get_theme_mod('banker_copyright_text', 'نقل و نشر مطالب با ذکر نام بنکر به مطالب بلامانع است. کلیه حقوق مادی و معنوی متعلق به بانکداران ۲۴ می باشد');
}