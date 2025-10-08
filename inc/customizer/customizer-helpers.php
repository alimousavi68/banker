<?php
/**
 * Customizer Helper Functions
 * 
 * Helper functions to retrieve customizer settings
 * 
 * @package Banker
 * @since 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Get Hero Section Settings
 */
function banker_get_hero_settings() {
    return array(
        'category' => get_theme_mod('banker_hero_category', 8),
        'posts_count' => get_theme_mod('banker_hero_posts_count', 5),
    );
}

/**
 * Get Dashboard Section Settings
 */
function banker_get_dashboard_settings() {
    return array(
        'main_category' => get_theme_mod('banker_dashboard_main_category', 8),
        'main_posts_count' => get_theme_mod('banker_dashboard_main_posts_count', 6),
        'main_title' => get_theme_mod('banker_dashboard_main_title', 'پیشخوان اخبار'),
        'latest_category' => get_theme_mod('banker_dashboard_latest_category', 8),
        'latest_posts_count' => get_theme_mod('banker_dashboard_latest_posts_count', 7),
        'latest_title' => get_theme_mod('banker_dashboard_latest_title', 'آخرین اخبار'),
    );
}

/**
 * Get Banking Section Settings
 */
function banker_get_banking_settings() {
    return array(
        'category' => get_theme_mod('banker_banking_category', 8),
        'posts_count' => get_theme_mod('banker_banking_posts_count', 5),
        'title' => get_theme_mod('banker_banking_title', 'بانکداری'),
        'show_category' => get_theme_mod('banker_banking_show_category', true),
    );
}

/**
 * Get Crypto Section Settings
 */
function banker_get_crypto_settings() {
    return array(
        'main_category' => get_theme_mod('banker_crypto_main_category', 8),
        'main_posts_count' => get_theme_mod('banker_crypto_main_posts_count', 4),
        'main_title' => get_theme_mod('banker_crypto_main_title', 'ارز دیجیتال'),
        'gold_category' => get_theme_mod('banker_crypto_gold_category', 8),
        'gold_posts_count' => get_theme_mod('banker_crypto_gold_posts_count', 9),
        'gold_title' => get_theme_mod('banker_crypto_gold_title', 'طلا و ارز'),
    );
}

/**
 * Get Banker View Section Settings
 */
function banker_get_banker_view_settings() {
    return array(
        'main_category' => get_theme_mod('banker_view_main_category', 8),
        'main_posts_count' => get_theme_mod('banker_view_main_posts_count', 5),
        'main_title' => get_theme_mod('banker_view_main_title', 'نگاه بنکر'),
        'news_category' => get_theme_mod('banker_view_news_category', 8),
        'news_posts_count' => get_theme_mod('banker_view_news_posts_count', 6),
        'news_title' => get_theme_mod('banker_view_news_title', 'دیگه چه خبر'),
    );
}

/**
 * Get Car Section Settings
 */
function banker_get_car_settings() {
    return array(
        'main_category' => get_theme_mod('banker_car_main_category', 8),
        'main_posts_count' => get_theme_mod('banker_car_main_posts_count', 2),
        'main_title' => get_theme_mod('banker_car_main_title', 'خودرو'),
        'economy_category' => get_theme_mod('banker_car_economy_category', 8),
        'economy_posts_count' => get_theme_mod('banker_car_economy_posts_count', 3),
        'economy_title' => get_theme_mod('banker_car_economy_title', 'اقتصاد و بیمه'),
    );
}

/**
 * Get History Section Settings
 */
function banker_get_history_settings() {
    return array(
        'main_category' => get_theme_mod('banker_history_main_category', 8),
        'main_posts_count' => get_theme_mod('banker_history_main_posts_count', 5),
        'main_title' => get_theme_mod('banker_history_main_title', 'تاریخ و اقتصاد'),
        'notes_category' => get_theme_mod('banker_history_notes_category', 8),
        'notes_posts_count' => get_theme_mod('banker_history_notes_posts_count', 3),
        'notes_title' => get_theme_mod('banker_history_notes_title', 'یادداشت ها'),
    );
}