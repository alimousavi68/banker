<?php
/**
 * Homepage Customizer Helper Functions
 * 
 * This file contains helper functions to retrieve homepage customizer settings
 * 
 * @package Banker
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get Hero Section Settings
 */
function banker_get_hero_section_settings() {
    return array(
        'category'    => get_theme_mod('banker_hero_category', 8),
        'posts_count' => get_theme_mod('banker_hero_posts_count', 5),
    );
}

/**
 * Get Pishkhan Section Settings
 */
function banker_get_pishkhan_section_settings() {
    return array(
        'main_category'     => get_theme_mod('banker_pishkhan_main_category', 8),
        'main_posts_count'  => get_theme_mod('banker_pishkhan_main_posts_count', 6),
        'main_title'        => get_theme_mod('banker_pishkhan_main_title', 'پیشخوان اخبار'),
        'latest_type'       => get_theme_mod('banker_pishkhan_latest_type', 'recent'),
        'latest_category'   => get_theme_mod('banker_pishkhan_latest_category', 8),
        'latest_posts_count' => get_theme_mod('banker_pishkhan_latest_posts_count', 7),
        'latest_title'      => get_theme_mod('banker_pishkhan_latest_title', 'آخرین اخبار'),
    );
}

/**
 * Get Banking Section Settings
 */
function banker_get_banking_section_settings() {
    return array(
        'category'      => get_theme_mod('banker_banking_category', 8),
        'posts_count'   => get_theme_mod('banker_banking_posts_count', 5),
        'title'         => get_theme_mod('banker_banking_title', 'بانکداری'),
        'show_category' => get_theme_mod('banker_banking_show_category', true),
    );
}

/**
 * Get Crypto Section Settings
 */
function banker_get_crypto_section_settings() {
    return array(
        'category'           => get_theme_mod('banker_crypto_category', 8),
        'posts_count'        => get_theme_mod('banker_crypto_posts_count', 4),
        'title'              => get_theme_mod('banker_crypto_title', 'ارز دیجیتال'),
        'gold_category'      => get_theme_mod('banker_crypto_gold_category', 8),
        'gold_posts_count'   => get_theme_mod('banker_crypto_gold_posts_count', 9),
        'gold_title'         => get_theme_mod('banker_crypto_gold_title', 'طلا و ارز'),
    );
}

/**
 * Get Banker View Section Settings
 */
function banker_get_banker_view_section_settings() {
    return array(
        'main_category'     => get_theme_mod('banker_view_main_category', 8),
        'main_posts_count'  => get_theme_mod('banker_view_main_posts_count', 5),
        'main_title'        => get_theme_mod('banker_view_main_title', 'نگاه بنکر'),
        'news_category'     => get_theme_mod('banker_view_news_category', 8),
        'news_posts_count'  => get_theme_mod('banker_view_news_posts_count', 6),
    );
}

/**
 * Get Car Section Settings
 */
function banker_get_car_section_settings() {
    return array(
        'car_category'        => get_theme_mod('banker_car_category', 8),
        'car_posts_count'     => get_theme_mod('banker_car_posts_count', 2),
        'car_title'           => get_theme_mod('banker_car_title', 'خودرو'),
        'economy_category'    => get_theme_mod('banker_car_economy_category', 8),
        'economy_posts_count' => get_theme_mod('banker_car_economy_posts_count', 3),
        'economy_title'       => get_theme_mod('banker_car_economy_title', 'اقتصاد و بیمه'),
    );
}

/**
 * Get History Section Settings
 */
function banker_get_history_section_settings() {
    return array(
        'main_category'     => get_theme_mod('banker_history_main_category', 8),
        'main_posts_count'  => get_theme_mod('banker_history_main_posts_count', 5),
        'main_title'        => get_theme_mod('banker_history_main_title', 'تاریخ و اقتصاد'),
        'notes_category'    => get_theme_mod('banker_history_notes_category', 8),
        'notes_posts_count' => get_theme_mod('banker_history_notes_posts_count', 3),
        'notes_title'       => get_theme_mod('banker_history_notes_title', 'یادداشت‌ها'),
    );
}

/**
 * Get all homepage settings at once
 */
function banker_get_all_homepage_settings() {
    return array(
        'hero'        => banker_get_hero_section_settings(),
        'pishkhan'    => banker_get_pishkhan_section_settings(),
        'banking'     => banker_get_banking_section_settings(),
        'crypto'      => banker_get_crypto_section_settings(),
        'banker_view' => banker_get_banker_view_section_settings(),
        'car'         => banker_get_car_section_settings(),
        'history'     => banker_get_history_section_settings(),
    );
}