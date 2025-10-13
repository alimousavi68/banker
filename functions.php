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
    
    // Add theme support for comments
    add_theme_support('html5', array('comment-list', 'comment-form', 'search-form'));
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'banker'),
        'desktop' => __('Desktop Menu', 'banker'),
    ));
}
add_action('after_setup_theme', 'banker_theme_setup');

/**
 * Register Sidebars
 */
function banker_register_sidebars() {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'banker'),
        'id'            => 'primary-sidebar',
        'description'   => __('سایدبار اصلی برای صفحات مقاله', 'banker'),
        'before_widget' => '<div id="%1$s" class="widget mb-6 bg-white border-b border-border pb-4 %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title text-lg font-bold text-black mb-4 flex items-center gap-2"><div class="w-1 h-5 bg-secondary rounded"></div>',
        'after_title'   => '</h3><div class="space-y-[2px] mb-4"><div class="border-t-2 border-dotted border-border"></div><div class="border-t-2 border-dotted border-border"></div><div class="border-t-2 border-dotted border-border"></div></div>',
    ));
}
add_action('widgets_init', 'banker_register_sidebars');

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
 * Comment System Functions
 */

// Enqueue comment reply script
function banker_enqueue_comment_reply() {
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'banker_enqueue_comment_reply');

// Custom comment form fields
function banker_comment_form_fields($fields) {
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    
    $fields['author'] = '<div class="mb-4">
        <input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" 
               placeholder="نام شما' . ($req ? ' *' : '') . '" 
               class="w-full px-4 py-3 border border-border rounded-sm focus:outline-none focus:border-secondary text-sm"' . $aria_req . ' />
    </div>';
    
    $fields['email'] = '<div class="mb-4">
        <input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" 
               placeholder="ایمیل شما' . ($req ? ' *' : '') . '" 
               class="w-full px-4 py-3 border border-border rounded-sm focus:outline-none focus:border-secondary text-sm"' . $aria_req . ' />
    </div>';
    
    $fields['url'] = '<div class="mb-4">
        <input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" 
               placeholder="وبسایت شما (اختیاری)" 
               class="w-full px-4 py-3 border border-border rounded-sm focus:outline-none focus:border-secondary text-sm" />
    </div>';
    
    return $fields;
}
add_filter('comment_form_default_fields', 'banker_comment_form_fields');

// Custom comment form args
function banker_comment_form_args($args) {
    $args['comment_field'] = '<div class="mb-4">
        <textarea id="comment" name="comment" rows="6" 
                  placeholder="دیدگاه شما..." 
                  class="w-full px-4 py-3 border border-border rounded-sm focus:outline-none focus:border-secondary text-sm resize-none" 
                  aria-required="true"></textarea>
    </div>';
    
    $args['submit_button'] = '<button type="submit" class="bg-secondary text-white px-6 py-3 rounded-sm hover:bg-opacity-90 transition-colors text-sm font-medium">
        ارسال دیدگاه
    </button>';
    
    $args['title_reply'] = 'دیدگاه شما';
    $args['title_reply_to'] = 'پاسخ به %s';
    $args['cancel_reply_link'] = 'لغو پاسخ';
    $args['label_submit'] = 'ارسال دیدگاه';
    $args['comment_notes_before'] = '';
    $args['comment_notes_after'] = '';
    
    return $args;
}
add_filter('comment_form_defaults', 'banker_comment_form_args');

// Add custom CSS classes to comment form
function banker_comment_form_class($form_class) {
    return 'bg-white border border-border rounded-sm p-6 mb-8';
}
add_filter('comment_form_class', 'banker_comment_form_class');

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
require_once get_template_directory() . '/inc/customizer/menu-content-customizer.php';

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
    
    // Enqueue price ticker script
    wp_enqueue_script('banker-price-ticker', get_template_directory_uri() . '/js/price-ticker.js', array(), '1.0.0', true);

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

/**
 * Display Dynamic Mobile Menu
 */
function banker_display_mobile_menu() {
    // Check if primary menu exists
    if (has_nav_menu('primary')) {
        wp_nav_menu(array(
            'theme_location' => 'primary',
            'container'      => false,
            'menu_class'     => 'flex px-5 flex-col gap-4 relative',
            'walker'         => new Banker_Mobile_Walker(),
            'depth'          => 2, // Support up to 2 levels
            'fallback_cb'    => 'banker_mobile_menu_fallback'
        ));
    } else {
        // Fallback if no menu is assigned
        banker_mobile_menu_fallback();
    }
}

/**
 * Fallback Mobile Menu (if no menu is assigned)
 */
function banker_mobile_menu_fallback() {
    echo '<div class="flex px-5 flex-col gap-4 relative">';
    echo '<a href="' . esc_url(home_url('/')) . '" class="py-2 px-2 hover:bg-blue-50 rounded block">خانه</a>';
    
    // Get recent posts for fallback menu
    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => 5,
        'post_status' => 'publish'
    ));
    
    if (!empty($recent_posts)) {
        echo '<div class="relative">';
        echo '<button id="submenu-btn-fallback" class="w-full text-right flex gap-2 justify-between items-center hover:text-secondary py-2 px-2">';
        echo '<span>مطالب اخیر</span>';
        echo '<svg xmlns="http://www.w3.org/2000/svg" id="submenu-icon-fallback" class="w-4 h-4 text-gray-500 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
        echo '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
        echo '</svg>';
        echo '</button>';
        
        echo '<div id="submenu-fallback" class="hidden flex-col absolute right-0 top-full bg-white shadow-lg rounded-md md:border md:border-gray-100 min-w-[160px] z-50">';
        foreach ($recent_posts as $post) {
            echo '<a href="' . esc_url(get_permalink($post['ID'])) . '" class="px-4 py-2 text-sm block hover:bg-blue-50">' . esc_html($post['post_title']) . '</a>';
        }
        echo '</div>';
        echo '</div>';
    }
    
    // Add some default menu items
    echo '<a href="' . esc_url(home_url('/about')) . '" class="py-2 px-2 hover:bg-blue-50 rounded block">درباره ما</a>';
    echo '<a href="' . esc_url(home_url('/contact')) . '" class="py-2 px-2 hover:bg-blue-50 rounded block">تماس با ما</a>';
    echo '</div>';
}

// Custom Walker for Mobile Menu
class Banker_Mobile_Walker extends Walker_Nav_Menu {
    
    // Start Level - wrapper for the sub menu
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"hidden flex-col absolute right-0 top-full bg-white shadow-lg rounded-md md:border md:border-gray-100 min-w-[160px] z-50\" id=\"submenu-{$this->current_item_id}\">\n";
    }

    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</div>\n";
    }

    // Start Element - each menu item
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $this->current_item_id = $item->ID;
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        if ($depth == 0) {
            // Top level items
            $has_children = in_array('menu-item-has-children', $classes);
            
            if ($has_children) {
                // Parent item with dropdown
                $output .= $indent . '<div class="relative">';
                $output .= '<button id="submenu-btn-' . $item->ID . '" class="w-full text-right flex gap-2 justify-between items-center hover:text-secondary py-2 px-2">';
                $output .= '<span>' . apply_filters('the_title', $item->title, $item->ID) . '</span>';
                $output .= '<svg xmlns="http://www.w3.org/2000/svg" id="submenu-icon-' . $item->ID . '" class="w-4 h-4 text-gray-500 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">';
                $output .= '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
                $output .= '</svg>';
                $output .= '</button>';
            } else {
                // Regular menu item
                $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
                $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
                $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
                $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
                
                $output .= $indent . '<a' . $attributes . ' class="py-2 px-2 hover:bg-blue-50 rounded block">';
                $output .= apply_filters('the_title', $item->title, $item->ID);
                $output .= '</a>';
            }
        } else {
            // Sub menu items
            $attributes = ! empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
            $attributes .= ! empty($item->target)     ? ' target="' . esc_attr($item->target     ) .'"' : '';
            $attributes .= ! empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn        ) .'"' : '';
            $attributes .= ! empty($item->url)        ? ' href="'   . esc_attr($item->url        ) .'"' : '';
            
            $output .= $indent . '<a' . $attributes . ' class="px-4 py-2 text-sm block hover:bg-blue-50">';
            $output .= apply_filters('the_title', $item->title, $item->ID);
            $output .= '</a>';
        }
    }

    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        
        if ($depth == 0 && $has_children) {
            $output .= "</div>\n";
        }
    }
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
