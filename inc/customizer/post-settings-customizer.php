<?php
/**
 * Post Settings Customizer
 * 
 * This file contains all customizer settings for special post features
 * 
 * @package Banker
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Include TinyMCE Control Class
require_once get_template_directory() . '/inc/customizer/class-wp-customize-tinymce-control.php';

// Include Ads Control Class
require_once get_template_directory() . '/inc/customizer/class-wp-customize-ads-control.php';

/**
 * Add Post Settings Customizer
 */
function banker_post_settings_customize_register($wp_customize) {
    
    // Add Post Settings Panel
    $wp_customize->add_panel('banker_post_settings_panel', array(
        'title'       => __('تنظیمات ویژه پست', 'banker'),
        'description' => __('تنظیمات مربوط به متن پیش‌فرض، متن انتهای پست و کدهای تبلیغاتی', 'banker'),
        'priority'    => 35,
    ));

    // ========================================
    // Post Prefix Text Section
    // ========================================
    $wp_customize->add_section('banker_post_prefix_section', array(
        'title'    => __('متن پیش‌فرض ابتدای پست', 'banker'),
        'panel'    => 'banker_post_settings_panel',
        'priority' => 10,
        'description' => __('متن وارد شده به صورت خودکار در ابتدای هر پست نمایش داده می‌شود', 'banker'),
    ));

    // Enable Prefix Text
    $wp_customize->add_setting('banker_post_prefix_enable', array(
        'default'           => false,
        'sanitize_callback' => 'banker_post_settings_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_post_prefix_enable', array(
        'label'   => __('فعال‌سازی متن پیش‌فرض', 'banker'),
        'section' => 'banker_post_prefix_section',
        'type'    => 'checkbox',
    ));

    // Prefix Text Content
    $wp_customize->add_setting('banker_post_prefix_content', array(
        'default'           => 'به گزارش پایگاه خبری بنکر، ',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_TinyMCE_Control($wp_customize, 'banker_post_prefix_content', array(
        'label'       => __('محتوای متن پیش‌فرض', 'banker'),
        'section'     => 'banker_post_prefix_section',
        'settings'    => 'banker_post_prefix_content',
        'description' => __('این متن فقط در صورت فعال بودن گزینه بالا نمایش داده می‌شود. می‌توانید از امکانات ویرایش متن مانند bold، italic، لینک و تغییر رنگ استفاده کنید.', 'banker'),
    )));

    // ========================================
    // Post Suffix Text Section
    // ========================================
    $wp_customize->add_section('banker_post_suffix_section', array(
        'title'    => __('متن انتهای پست', 'banker'),
        'panel'    => 'banker_post_settings_panel',
        'priority' => 20,
        'description' => __('متن وارد شده به صورت خودکار در انتهای هر پست نمایش داده می‌شود', 'banker'),
    ));

    // Enable Suffix Text
    $wp_customize->add_setting('banker_post_suffix_enable', array(
        'default'           => false,
        'sanitize_callback' => 'banker_post_settings_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_post_suffix_enable', array(
        'label'   => __('فعال‌سازی متن انتهای پست', 'banker'),
        'section' => 'banker_post_suffix_section',
        'type'    => 'checkbox',
    ));

    // Suffix Text Content
    $wp_customize->add_setting('banker_post_suffix_content', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control(new WP_Customize_TinyMCE_Control($wp_customize, 'banker_post_suffix_content', array(
        'label'       => __('محتوای متن انتهای پست', 'banker'),
        'section'     => 'banker_post_suffix_section',
        'settings'    => 'banker_post_suffix_content',
        'description' => __('این متن فقط در صورت فعال بودن گزینه بالا نمایش داده می‌شود. می‌توانید از امکانات ویرایش متن مانند bold، italic، لینک و تغییر رنگ استفاده کنید.', 'banker'),
    )));

    // ========================================
    // Inline Related Posts Section
    // ========================================
    $wp_customize->add_section('banker_related_inline_section', array(
        'title'    => __('مطالب مرتبط درون‌متنی', 'banker'),
        'panel'    => 'banker_post_settings_panel',
        'priority' => 25,
        'description' => __('مدیریت تعداد و جایگاه نمایش مطالب مرتبط داخل متن.', 'banker'),
    ));

    // Enable Related Inline
    $wp_customize->add_setting('banker_related_inline_enable', array(
        'default'           => false,
        'sanitize_callback' => 'banker_post_settings_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('banker_related_inline_enable', array(
        'label'   => __('فعال‌سازی مطالب مرتبط درون‌متنی', 'banker'),
        'section' => 'banker_related_inline_section',
        'type'    => 'checkbox',
    ));

    // Count
    $wp_customize->add_setting('banker_related_inline_count', array(
        'default'           => 3,
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('banker_related_inline_count', array(
        'label'       => __('تعداد مطالب مرتبط', 'banker'),
        'section'     => 'banker_related_inline_section',
        'type'        => 'number',
        'input_attrs' => array('min' => 1, 'max' => 10),
    ));

    // Position
    $wp_customize->add_setting('banker_related_inline_position', array(
        'default'           => 'post_middle',
        'sanitize_callback' => 'banker_sanitize_related_inline_position',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('banker_related_inline_position', array(
        'label'   => __('جایگاه نمایش', 'banker'),
        'section' => 'banker_related_inline_section',
        'type'    => 'select',
        'choices' => array(
            'paragraph_1' => __('بعد از پاراگراف اول', 'banker'),
            'paragraph_2' => __('بعد از پاراگراف دوم', 'banker'),
            'paragraph_3' => __('بعد از پاراگراف سوم', 'banker'),
            'post_middle' => __('میانه محتوا', 'banker'),
            'post_end'    => __('انتهای محتوا', 'banker'),
        ),
    ));

    // Title
    $wp_customize->add_setting('banker_related_inline_title', array(
        'default'           => 'مطالب مرتبط',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ));
    $wp_customize->add_control('banker_related_inline_title', array(
        'label'   => __('عنوان بخش', 'banker'),
        'section' => 'banker_related_inline_section',
        'type'    => 'text',
    ));

    // ========================================
    // Advertisement Management Section
    // ========================================
    $wp_customize->add_section('banker_ad_management_section', array(
        'title'    => __('مدیریت کدهای تبلیغاتی', 'banker'),
        'panel'    => 'banker_post_settings_panel',
        'priority' => 30,
        'description' => __('افزودن و مدیریت کدهای تبلیغاتی با موقعیت‌های مختلف نمایش', 'banker'),
    ));

    // Enable Advertisement System
    $wp_customize->add_setting('banker_ads_enable', array(
        'default'           => false,
        'sanitize_callback' => 'banker_post_settings_sanitize_checkbox',
        'transport'         => 'postMessage',
    ));

    $wp_customize->add_control('banker_ads_enable', array(
        'label'   => __('فعال‌سازی سیستم تبلیغات', 'banker'),
        'section' => 'banker_ad_management_section',
        'type'    => 'checkbox',
        'description' => __('ابتدا این گزینه را فعال کنید تا بتوانید تبلیغات را مدیریت کنید', 'banker'),
    ));

    // Add dynamic settings for up to 20 ads
    for ($i = 1; $i <= 20; $i++) {
        // Ad Enable
        $wp_customize->add_setting("banker_ad_{$i}_enable", array(
            'default'           => false,
            'sanitize_callback' => 'banker_post_settings_sanitize_checkbox',
            'transport'         => 'postMessage',
        ));

        // Ad Code
        $wp_customize->add_setting("banker_ad_{$i}_code", array(
            'default'           => '',
            'sanitize_callback' => 'banker_sanitize_ad_code',
            'transport'         => 'postMessage',
        ));

        // Ad Position
        $wp_customize->add_setting("banker_ad_{$i}_position", array(
            'default'           => 'post_start',
            'sanitize_callback' => 'banker_sanitize_ad_position',
            'transport'         => 'postMessage',
        ));
    }

    // Add the dynamic ads management control
    $wp_customize->add_control(new WP_Customize_Ads_Control($wp_customize, 'banker_ads_manager', array(
        'label'       => __('مدیریت تبلیغات', 'banker'),
        'section'     => 'banker_ad_management_section',
        'settings'    => 'banker_ads_enable',
        'description' => __('با استفاده از دکمه "افزودن تبلیغ جدید" می‌توانید تبلیغات جدید ایجاد کنید. هر تبلیغ شامل سوئیچ فعال/غیرفعال، کد تبلیغاتی و انتخاب موقعیت نمایش است.', 'banker'),
    )));
}

/**
 * Sanitize checkbox values for post settings
 */
function banker_post_settings_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Sanitize advertisement codes
 */
function banker_sanitize_ads_codes($input) {
    // Allow HTML and JavaScript for ad codes
    return $input;
}

/**
 * Sanitize individual ad code
 */
function banker_sanitize_ad_code($input) {
    // Allow HTML and JavaScript for ad codes
    return $input;
}

/**
 * Sanitize ad position
 */
function banker_sanitize_ad_position($input) {
    $valid_positions = array(
        'post_start',
        'paragraph_1',
        'paragraph_2', 
        'paragraph_3',
        'post_middle',
        'post_end'
    );
    
    if (in_array($input, $valid_positions)) {
        return $input;
    }
    
    return 'post_start';
}





/**
 * Enqueue Customizer JavaScript and Styles
 */
function banker_post_settings_customize_controls_enqueue_scripts() {
    wp_enqueue_script( 'wp-tinymce' );
    wp_enqueue_script( 'wp-editor' );
    wp_enqueue_media();
    wp_enqueue_style( 'editor-buttons' );
    wp_enqueue_style( 'wp-admin' );
    
    // Add editor CSS styles
    wp_add_inline_style( 'wp-admin', '
        .customize-control-tinymce_editor .wp-editor-wrap {
            border: 1px solid #ddd;
            border-radius: 3px;
            background: #fff;
            margin-top: 5px;
        }
        .customize-control-tinymce_editor .wp-editor-tools {
            border-bottom: 1px solid #ddd;
            background: #f9f9f9;
            padding: 8px;
            overflow: hidden;
        }
        .customize-control-tinymce_editor .wp-editor-container {
            background: #fff;
            position: relative;
        }
        .customize-control-tinymce_editor .wp-editor-area {
            border: none;
            box-shadow: none;
            resize: vertical;
            font-family: Consolas, Monaco, monospace;
            font-size: 13px;
            line-height: 1.4;
            padding: 10px;
            width: 100%;
            min-height: 200px;
        }
        .customize-control-tinymce_editor .wp-media-buttons .button {
            margin-right: 5px;
            padding: 2px 8px;
            font-size: 12px;
        }
        .customize-control-tinymce_editor .wp-editor-tabs {
            float: right;
        }
        .customize-control-tinymce_editor .wp-switch-editor {
            background: #f7f7f7;
            border: 1px solid #ccc;
            color: #666;
            cursor: pointer;
            float: left;
            font-size: 13px;
            line-height: 1;
            margin: 0;
            outline: 0;
            padding: 3px 8px 4px;
            position: relative;
            text-decoration: none;
        }
        .customize-control-tinymce_editor .wp-switch-editor:hover {
            background: #fafafa;
            color: #333;
        }
        .customize-control-tinymce_editor .tmce-active .switch-tmce,
        .customize-control-tinymce_editor .html-active .switch-html {
            background: #fff;
            color: #333;
            border-bottom-color: #fff;
        }
        .customize-control-tinymce_editor .quicktags-toolbar {
            background: #f1f1f1;
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }
        .customize-control-tinymce_editor .ed_button {
            background: #f7f7f7;
            border: 1px solid #ccc;
            color: #555;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
            padding: 2px 8px;
        }
        .customize-control-tinymce_editor .ed_button:hover {
            background: #fafafa;
            border-color: #999;
        }
        .customize-control-tinymce_editor .mce-tinymce {
            border: none !important;
        }
        .customize-control-tinymce_editor .mce-toolbar-grp {
            background: #f9f9f9;
            border-bottom: 1px solid #ddd;
        }
        .customize-control-tinymce_editor .mce-btn {
            border: 1px solid transparent;
            margin: 2px;
        }
        .customize-control-tinymce_editor .mce-btn:hover {
            border-color: #ccc;
            background: #fff;
        }
        .customize-control-tinymce_editor .mce-btn.mce-active {
            background: #e5e5e5;
            border-color: #aaa;
        }
    ' );
}

/**
 * Enqueue customizer JavaScript and styles
 */
function banker_post_settings_customize_preview_js() {
    // Use core helpers to enqueue editor and media with proper settings
    wp_enqueue_editor();
    wp_enqueue_media();

    // Editor UI styles
    wp_enqueue_style('editor-buttons');
}

// Hook into customize_register
add_action('customize_register', 'banker_post_settings_customize_register');

// Enqueue customizer JavaScript
add_action('customize_controls_enqueue_scripts', 'banker_post_settings_customize_preview_js');