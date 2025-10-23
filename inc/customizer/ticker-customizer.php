<?php
if (!defined('ABSPATH')) { exit; }

function banker_ticker_customize_register($wp_customize) {
    $wp_customize->add_section('banker_ticker_section', array(
        'title' => __('نوار خبر (Ticker)', 'banker'),
        'priority' => 35,
        'description' => __('تنظیمات نوار خبر در هدر سایت', 'banker'),
    ));

    // Enable/Disable ticker
    $wp_customize->add_setting('banker_news_ticker_enabled', array(
        'default' => true,
        'sanitize_callback' => function($val){ return (bool)$val; },
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banker_news_ticker_enabled', array(
        'label' => __('فعال‌سازی نوار خبر', 'banker'),
        'section' => 'banker_ticker_section',
        'type' => 'checkbox',
    ));

    // Posts count
    $wp_customize->add_setting('banker_news_ticker_posts_count', array(
        'default' => 10,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banker_news_ticker_posts_count', array(
        'label' => __('تعداد خبرها', 'banker'),
        'section' => 'banker_ticker_section',
        'type' => 'number',
        'input_attrs' => array('min' => 1, 'max' => 50),
    ));

    // Category select
    $choices = array(0 => __('بدون فیلتر', 'banker'));
    $cats = get_categories(array('hide_empty' => false));
    foreach ($cats as $cat) { $choices[$cat->term_id] = $cat->name; }

    $wp_customize->add_setting('banker_news_ticker_category', array(
        'default' => 0,
        'sanitize_callback' => 'absint',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('banker_news_ticker_category', array(
        'label' => __('انتخاب دسته‌بندی', 'banker'),
        'section' => 'banker_ticker_section',
        'type' => 'select',
        'choices' => $choices,
    ));
}
add_action('customize_register', 'banker_ticker_customize_register');