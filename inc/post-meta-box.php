<?php
/**
 * Custom Meta Box for Additional Post Information
 * 
 * This file contains the meta box for additional post information including:
 * - Main category selection
 * - Post type selection (Simple/Note)
 * - Conditional fields for note type posts
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Banker_Post_Meta_Box {
    
    public function __construct() {
        add_action('add_meta_boxes', array($this, 'add_meta_box'));
        add_action('save_post', array($this, 'save_meta_box'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    /**
     * Add meta box to post edit screen
     */
    public function add_meta_box() {
        add_meta_box(
            'banker_post_additional_info',
            'اطلاعات اضافی پست',
            array($this, 'meta_box_callback'),
            'post',
            'side',
            'high'
        );
    }
    
    /**
     * Meta box callback function
     */
    public function meta_box_callback($post) {
        // Add nonce field for security
        wp_nonce_field('banker_post_meta_box', 'banker_post_meta_box_nonce');
        
        // Get current values
        $main_category = get_post_meta($post->ID, '_banker_main_category', true);
        $post_type = get_post_meta($post->ID, '_banker_post_type', true);
        $note_author = get_post_meta($post->ID, '_banker_note_author', true);
        $note_author_image = get_post_meta($post->ID, '_banker_note_author_image', true);
        
        // Set default values
        if (empty($post_type)) {
            $post_type = 'simple';
        }
        
        // Get all categories
        $categories = get_categories(array(
            'hide_empty' => false,
            'orderby' => 'name',
            'order' => 'ASC'
        ));
        ?>
        
        <div class="banker-meta-box" style="padding: 10px 0;">
            
            <!-- Main Category Selection -->
            <div class="banker-field-group" style="margin-bottom: 20px;">
                <label for="banker_main_category" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1d2327;">
                    <span style="color: #d63384;">*</span> دسته‌بندی اصلی:
                </label>
                <select name="banker_main_category" id="banker_main_category" style="width: 100%; padding: 8px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff;">
                    <option value="">انتخاب دسته‌بندی...</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?php echo esc_attr($category->term_id); ?>" <?php selected($main_category, $category->term_id); ?>>
                            <?php echo esc_html($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Post Type Selection -->
            <div class="banker-field-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1d2327;">
                    <span style="color: #d63384;">*</span> نوع پست:
                </label>
                <div style="display: flex; gap: 15px; margin-top: 8px;">
                    <label style="display: flex; align-items: center; cursor: pointer; font-weight: normal;">
                        <input type="radio" name="banker_post_type" value="simple" <?php checked($post_type, 'simple'); ?> style="margin-left: 8px;">
                        ساده
                    </label>
                    <label style="display: flex; align-items: center; cursor: pointer; font-weight: normal;">
                        <input type="radio" name="banker_post_type" value="note" <?php checked($post_type, 'note'); ?> style="margin-left: 8px;">
                        یادداشت
                    </label>
                </div>
            </div>
            
            <!-- Conditional Fields for Note Type -->
            <div id="note-fields" style="<?php echo ($post_type !== 'note') ? 'display: none;' : ''; ?>">
                
                <!-- Note Author Name -->
                <div class="banker-field-group" style="margin-bottom: 20px;">
                    <label for="banker_note_author" style="display: block; font-weight: 600; margin-bottom: 8px; color: #1d2327;">
                        نام نویسنده یادداشت:
                    </label>
                    <input type="text" name="banker_note_author" id="banker_note_author" value="<?php echo esc_attr($note_author); ?>" 
                           style="width: 100%; padding: 8px; border: 1px solid #8c8f94; border-radius: 4px;" 
                           placeholder="نام نویسنده را وارد کنید...">
                </div>
                
                <!-- Note Author Image -->
                <div class="banker-field-group" style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; color: #1d2327;">
                        تصویر نویسنده:
                    </label>
                    <div class="banker-image-upload">
                        <input type="hidden" name="banker_note_author_image" id="banker_note_author_image" value="<?php echo esc_attr($note_author_image); ?>">
                        
                        <div id="image-preview" style="margin-bottom: 10px; <?php echo empty($note_author_image) ? 'display: none;' : ''; ?>">
                            <?php if (!empty($note_author_image)) : 
                                $image_url = wp_get_attachment_image_url($note_author_image, 'thumbnail');
                            ?>
                                <img src="<?php echo esc_url($image_url); ?>" style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 4px;">
                            <?php endif; ?>
                        </div>
                        
                        <div style="display: flex; gap: 10px;">
                            <button type="button" id="upload-image-btn" class="button" style="background: #2271b1; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer;">
                                <?php echo empty($note_author_image) ? 'انتخاب تصویر' : 'تغییر تصویر'; ?>
                            </button>
                            <button type="button" id="remove-image-btn" class="button" style="background: #d63384; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; <?php echo empty($note_author_image) ? 'display: none;' : ''; ?>">
                                حذف تصویر
                            </button>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
        
        <style>
            .banker-meta-box .banker-field-group label {
                font-size: 13px;
            }
            
            .banker-meta-box input[type="text"],
            .banker-meta-box select {
                font-size: 13px;
            }
            
            .banker-meta-box input[type="radio"] {
                margin: 0 8px 0 0;
            }
            
            .banker-meta-box .button:hover {
                opacity: 0.9;
            }
            
            #note-fields {
                border-top: 1px solid #e0e0e0;
                padding-top: 15px;
                margin-top: 15px;
                display: none; /* Initially hidden */
            }
        </style>
        
        <?php
    }
    
    /**
     * Save meta box data
     */
    public function save_meta_box($post_id) {
        // Check if nonce is valid
        if (!isset($_POST['banker_post_meta_box_nonce']) || !wp_verify_nonce($_POST['banker_post_meta_box_nonce'], 'banker_post_meta_box')) {
            return;
        }
        
        // Check if user has permission to edit post
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Check if this is an autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        // Save main category
        if (isset($_POST['banker_main_category'])) {
            update_post_meta($post_id, '_banker_main_category', sanitize_text_field($_POST['banker_main_category']));
        }
        
        // Save post type
        if (isset($_POST['banker_post_type'])) {
            $post_type = sanitize_text_field($_POST['banker_post_type']);
            update_post_meta($post_id, '_banker_post_type', $post_type);
            
            // Save note-specific fields only if post type is 'note'
            if ($post_type === 'note') {
                if (isset($_POST['banker_note_author'])) {
                    update_post_meta($post_id, '_banker_note_author', sanitize_text_field($_POST['banker_note_author']));
                }
                
                if (isset($_POST['banker_note_author_image'])) {
                    update_post_meta($post_id, '_banker_note_author_image', absint($_POST['banker_note_author_image']));
                }
            } else {
                // Remove note-specific fields if post type is not 'note'
                delete_post_meta($post_id, '_banker_note_author');
                delete_post_meta($post_id, '_banker_note_author_image');
            }
        }
    }
    
    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts($hook) {
        // Only load on post edit screens
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }
        
        // Enqueue jQuery first
        wp_enqueue_script('jquery');
        
        // Enqueue WordPress media uploader
        wp_enqueue_media();
        
        // Register and enqueue our custom script with jQuery dependency
        wp_register_script(
            'banker-meta-box-script',
            '',
            array('jquery', 'media-upload'),
            '1.0.0',
            true
        );
        wp_enqueue_script('banker-meta-box-script');
        
        // Add inline JavaScript for functionality
        $this->add_inline_script();
    }
    
    /**
     * Add inline JavaScript for meta box functionality
     */
    private function add_inline_script() {
        $script = '
        jQuery(document).ready(function($) {
            
            // Function to toggle note fields
            function toggleNoteFields() {
                var selectedType = $(\'input[name="banker_post_type"]:checked\').val();
                if (selectedType === \'note\') {
                    $(\'#note-fields\').slideDown(300);
                } else {
                    $(\'#note-fields\').slideUp(300);
                }
            }
            
            // Set initial state on page load
            toggleNoteFields();
            
            // Toggle note fields based on post type selection
            $(\'input[name="banker_post_type"]\').change(function() {
                toggleNoteFields();
            });
            
            // Media uploader functionality
            var mediaUploader;
            
            $(\'#upload-image-btn\').click(function(e) {
                e.preventDefault();
                
                // If the uploader object has already been created, reopen the dialog
                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }
                
                // Create the media uploader
                mediaUploader = wp.media({
                    title: \'انتخاب تصویر نویسنده\',
                    button: {
                        text: \'انتخاب تصویر\'
                    },
                    multiple: false
                });
                
                // When an image is selected, run a callback
                mediaUploader.on(\'select\', function() {
                    var attachment = mediaUploader.state().get(\'selection\').first().toJSON();
                    
                    // Set the image ID
                    $(\'#banker_note_author_image\').val(attachment.id);
                    
                    // Show preview
                    var imageUrl = attachment.sizes && attachment.sizes.thumbnail ? 
                                  attachment.sizes.thumbnail.url : attachment.url;
                    
                    $(\'#image-preview\').html(\'<img src="\' + imageUrl + \'" style="max-width: 100px; height: auto; border: 1px solid #ddd; border-radius: 4px;">\').show();
                    
                    // Update button text and show remove button
                    $(\'#upload-image-btn\').text(\'تغییر تصویر\');
                    $(\'#remove-image-btn\').show();
                });
                
                // Open the uploader dialog
                mediaUploader.open();
            });
            
            // Remove image functionality
            $(\'#remove-image-btn\').click(function(e) {
                e.preventDefault();
                
                // Clear the image ID
                $(\'#banker_note_author_image\').val(\'\');
                
                // Hide preview
                $(\'#image-preview\').hide().html(\'\');
                
                // Update button text and hide remove button
                $(\'#upload-image-btn\').text(\'انتخاب تصویر\');
                $(this).hide();
            });
            
        });
        ';
        
        wp_add_inline_script('banker-meta-box-script', $script);
    }
}

// Initialize the meta box
new Banker_Post_Meta_Box();