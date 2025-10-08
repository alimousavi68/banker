<?php
/**
 * Homepage Customizer Settings
 * 
 * This file contains all customizer settings for homepage sections
 * 
 * @package Banker
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Homepage Customizer Settings
 */
function banker_homepage_customize_register($wp_customize) {
    
    // Add Homepage Panel
    $wp_customize->add_panel('banker_homepage_panel', array(
        'title'       => __('تنظیمات صفحه اصلی', 'banker'),
        'description' => __('تنظیمات مربوط به بخش‌های مختلف صفحه اصلی', 'banker'),
        'priority'    => 30,
    ));

    // ========================================
    // Hero Section Settings
    // ========================================
    $wp_customize->add_section('banker_hero_section', array(
        'title'    => __('بخش اول / هیروسکشن', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 10,
    ));

    // Hero Category
    $wp_customize->add_setting('banker_hero_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_hero_category', array(
        'label'    => __('دسته‌بندی محتوا', 'banker'),
        'section'  => 'banker_hero_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Hero Posts Count
    $wp_customize->add_setting('banker_hero_posts_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_hero_posts_count', array(
        'label'       => __('تعداد پست‌ها', 'banker'),
        'section'     => 'banker_hero_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // ========================================
    // Pishkhan Section Settings
    // ========================================
    $wp_customize->add_section('banker_pishkhan_section', array(
        'title'    => __('بخش دوم / پیشخوان', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 20,
    ));

    // Pishkhan Main Category
    $wp_customize->add_setting('banker_pishkhan_main_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_main_category', array(
        'label'    => __('دسته‌بندی پیشخوان اخبار', 'banker'),
        'section'  => 'banker_pishkhan_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Pishkhan Main Posts Count
    $wp_customize->add_setting('banker_pishkhan_main_posts_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_main_posts_count', array(
        'label'       => __('تعداد پست‌های پیشخوان اخبار', 'banker'),
        'section'     => 'banker_pishkhan_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Pishkhan Main Title
    $wp_customize->add_setting('banker_pishkhan_main_title', array(
        'default'           => 'پیشخوان اخبار',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_main_title', array(
        'label'   => __('عنوان بخش پیشخوان اخبار', 'banker'),
        'section' => 'banker_pishkhan_section',
        'type'    => 'text',
    ));

    // Pishkhan Latest News Category
    $wp_customize->add_setting('banker_pishkhan_latest_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_latest_category', array(
        'label'    => __('دسته‌بندی آخرین اخبار', 'banker'),
        'section'  => 'banker_pishkhan_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Pishkhan Latest News Posts Count
    $wp_customize->add_setting('banker_pishkhan_latest_posts_count', array(
        'default'           => 7,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_latest_posts_count', array(
        'label'       => __('تعداد پست‌های آخرین اخبار', 'banker'),
        'section'     => 'banker_pishkhan_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Pishkhan Latest News Title
    $wp_customize->add_setting('banker_pishkhan_latest_title', array(
        'default'           => 'آخرین اخبار',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_pishkhan_latest_title', array(
        'label'   => __('عنوان بخش آخرین اخبار', 'banker'),
        'section' => 'banker_pishkhan_section',
        'type'    => 'text',
    ));

    // ========================================
    // Banking Section Settings
    // ========================================
    $wp_customize->add_section('banker_banking_section', array(
        'title'    => __('بخش سوم / بانکداری', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 30,
    ));

    // Banking Category
    $wp_customize->add_setting('banker_banking_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_banking_category', array(
        'label'    => __('دسته‌بندی محتوا', 'banker'),
        'section'  => 'banker_banking_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Banking Posts Count
    $wp_customize->add_setting('banker_banking_posts_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_banking_posts_count', array(
        'label'       => __('تعداد پست‌ها', 'banker'),
        'section'     => 'banker_banking_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Banking Title
    $wp_customize->add_setting('banker_banking_title', array(
        'default'           => 'بانکداری',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_banking_title', array(
        'label'   => __('عنوان هدر بخش', 'banker'),
        'section' => 'banker_banking_section',
        'type'    => 'text',
    ));

    // Show Category in Banking Posts
    $wp_customize->add_setting('banker_banking_show_category', array(
        'default'           => true,
        'sanitize_callback' => 'banker_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_banking_show_category', array(
        'label'   => __('نمایش دسته‌بندی در پست‌ها', 'banker'),
        'section' => 'banker_banking_section',
        'type'    => 'checkbox',
    ));

    // ========================================
    // Crypto Section Settings
    // ========================================
    $wp_customize->add_section('banker_crypto_section', array(
        'title'    => __('بخش ارز دیجیتال', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 40,
    ));

    // Crypto Category
    $wp_customize->add_setting('banker_crypto_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_crypto_category', array(
        'label'    => __('دسته‌بندی محتوا', 'banker'),
        'section'  => 'banker_crypto_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Crypto Posts Count
    $wp_customize->add_setting('banker_crypto_posts_count', array(
        'default'           => 4,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_crypto_posts_count', array(
        'label'       => __('تعداد پست‌ها', 'banker'),
        'section'     => 'banker_crypto_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Crypto Title
    $wp_customize->add_setting('banker_crypto_title', array(
        'default'           => 'ارز دیجیتال',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_crypto_title', array(
        'label'   => __('عنوان هدر بخش', 'banker'),
        'section' => 'banker_crypto_section',
        'type'    => 'text',
    ));

    // ========================================
    // Banker View Section Settings
    // ========================================
    $wp_customize->add_section('banker_view_section', array(
        'title'    => __('بخش نگاه بنکر', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 50,
    ));

    // Banker View Main Category
    $wp_customize->add_setting('banker_view_main_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_view_main_category', array(
        'label'    => __('دسته‌بندی بخش اصلی', 'banker'),
        'section'  => 'banker_view_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Banker View Main Posts Count
    $wp_customize->add_setting('banker_view_main_posts_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_view_main_posts_count', array(
        'label'       => __('تعداد پست‌های بخش اصلی', 'banker'),
        'section'     => 'banker_view_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Banker View Main Title
    $wp_customize->add_setting('banker_view_main_title', array(
        'default'           => 'نگاه بنکر',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_view_main_title', array(
        'label'   => __('عنوان بخش اصلی', 'banker'),
        'section' => 'banker_view_section',
        'type'    => 'text',
    ));

    // Banker View News Category
    $wp_customize->add_setting('banker_view_news_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_view_news_category', array(
        'label'    => __('دسته‌بندی بخش اخبار', 'banker'),
        'section'  => 'banker_view_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Banker View News Posts Count
    $wp_customize->add_setting('banker_view_news_posts_count', array(
        'default'           => 6,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_view_news_posts_count', array(
        'label'       => __('تعداد پست‌های بخش اخبار', 'banker'),
        'section'     => 'banker_view_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // ========================================
    // Car Section Settings
    // ========================================
    $wp_customize->add_section('banker_car_section', array(
        'title'    => __('بخش خودرو', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 60,
    ));

    // Car Category
    $wp_customize->add_setting('banker_car_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_category', array(
        'label'    => __('دسته‌بندی بخش خودرو', 'banker'),
        'section'  => 'banker_car_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Car Posts Count
    $wp_customize->add_setting('banker_car_posts_count', array(
        'default'           => 2,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_posts_count', array(
        'label'       => __('تعداد پست‌های بخش خودرو', 'banker'),
        'section'     => 'banker_car_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Car Title
    $wp_customize->add_setting('banker_car_title', array(
        'default'           => 'خودرو',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_title', array(
        'label'   => __('عنوان بخش خودرو', 'banker'),
        'section' => 'banker_car_section',
        'type'    => 'text',
    ));

    // Car Economy Category
    $wp_customize->add_setting('banker_car_economy_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_economy_category', array(
        'label'    => __('دسته‌بندی بخش اقتصاد و بیمه', 'banker'),
        'section'  => 'banker_car_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // Car Economy Posts Count
    $wp_customize->add_setting('banker_car_economy_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_economy_posts_count', array(
        'label'       => __('تعداد پست‌های بخش اقتصاد و بیمه', 'banker'),
        'section'     => 'banker_car_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // Car Economy Title
    $wp_customize->add_setting('banker_car_economy_title', array(
        'default'           => 'اقتصاد و بیمه',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_car_economy_title', array(
        'label'   => __('عنوان بخش اقتصاد و بیمه', 'banker'),
        'section' => 'banker_car_section',
        'type'    => 'text',
    ));

    // ========================================
    // History Section Settings
    // ========================================
    $wp_customize->add_section('banker_history_section', array(
        'title'    => __('بخش تاریخ و اقتصاد', 'banker'),
        'panel'    => 'banker_homepage_panel',
        'priority' => 70,
    ));

    // History Main Category
    $wp_customize->add_setting('banker_history_main_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_main_category', array(
        'label'    => __('دسته‌بندی بخش اصلی', 'banker'),
        'section'  => 'banker_history_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // History Main Posts Count
    $wp_customize->add_setting('banker_history_main_posts_count', array(
        'default'           => 5,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_main_posts_count', array(
        'label'       => __('تعداد پست‌های بخش اصلی', 'banker'),
        'section'     => 'banker_history_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // History Main Title
    $wp_customize->add_setting('banker_history_main_title', array(
        'default'           => 'تاریخ و اقتصاد',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_main_title', array(
        'label'   => __('عنوان بخش اصلی', 'banker'),
        'section' => 'banker_history_section',
        'type'    => 'text',
    ));

    // History Notes Category
    $wp_customize->add_setting('banker_history_notes_category', array(
        'default'           => 8,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_notes_category', array(
        'label'    => __('دسته‌بندی بخش یادداشت‌ها', 'banker'),
        'section'  => 'banker_history_section',
        'type'     => 'select',
        'choices'  => banker_get_categories_choices(),
    ));

    // History Notes Posts Count
    $wp_customize->add_setting('banker_history_notes_posts_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_notes_posts_count', array(
        'label'       => __('تعداد پست‌های بخش یادداشت‌ها', 'banker'),
        'section'     => 'banker_history_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min' => 1,
            'max' => 20,
        ),
    ));

    // History Notes Title
    $wp_customize->add_setting('banker_history_notes_title', array(
        'default'           => 'یادداشت‌ها',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_history_notes_title', array(
        'label'   => __('عنوان بخش یادداشت‌ها', 'banker'),
        'section' => 'banker_history_section',
        'type'    => 'text',
    ));
}

/**
 * Get categories choices for select controls
 */
function banker_get_categories_choices() {
    $categories = get_categories(array(
        'hide_empty' => false,
    ));
    
    $choices = array();
    foreach ($categories as $category) {
        $choices[$category->term_id] = $category->name;
    }
    
    return $choices;
}

/**
 * Sanitize checkbox values
 */
function banker_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

// Hook into customize_register
add_action('customize_register', 'banker_homepage_customize_register');