<?php
/**
 * Custom Ads Management Control for WordPress Customizer
 * 
 * @package Banker
 */

if (class_exists('WP_Customize_Control')) {
    class WP_Customize_Ads_Control extends WP_Customize_Control {
        
        public $type = 'ads_manager';
        public $max_ads = 20; // Maximum number of ads allowed
        
        public function enqueue() {
            wp_enqueue_script('jquery-ui-sortable');
        }
        
        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                <?php if (!empty($this->description)) : ?>
                    <span class="description customize-control-description"><?php echo $this->description; ?></span>
                <?php endif; ?>
            </label>
            
            <div class="ads-manager-wrapper">
                <div class="ads-list" id="ads-list">
                    <!-- Existing ads will be loaded here -->
                </div>
                
                <div class="ads-controls">
                    <button type="button" class="button button-secondary add-ad-btn" id="add-ad-btn">
                        <span class="dashicons dashicons-plus-alt"></span>
                        افزودن تبلیغ جدید
                    </button>
                    <span class="ads-count">تعداد تبلیغات: <span id="ads-counter">0</span></span>
                </div>
            </div>
            
            <script type="text/javascript">
            jQuery(document).ready(function($) {
                var adsManager = {
                    maxAds: <?php echo $this->max_ads; ?>,
                    currentCount: 0,
                    
                    init: function() {
                        this.loadExistingAds();
                        this.bindEvents();
                        this.updateCounter();
                    },
                    
                    loadExistingAds: function() {
                        // Load existing ads from customizer settings
                        for (var i = 1; i <= 10; i++) {
                            var enableSetting = wp.customize('banker_ad_' + i + '_enable');
                            var codeSetting = wp.customize('banker_ad_' + i + '_code');
                            var positionSetting = wp.customize('banker_ad_' + i + '_position');
                            
                            if (enableSetting && (enableSetting.get() || codeSetting.get())) {
                                this.addAdItem(i, {
                                    enable: enableSetting.get(),
                                    code: codeSetting.get(),
                                    position: positionSetting.get()
                                });
                            }
                        }
                    },
                    
                    bindEvents: function() {
                        var self = this;
                        
                        $('#add-ad-btn').on('click', function() {
                            if (self.currentCount < self.maxAds) {
                                var newId = self.getNextAvailableId();
                                self.addAdItem(newId);
                                self.updateCounter();
                            } else {
                                alert('حداکثر ' + self.maxAds + ' تبلیغ مجاز است.');
                            }
                        });
                        
                        $(document).on('click', '.remove-ad', function() {
                            var adId = $(this).data('ad-id');
                            self.removeAdItem(adId);
                            self.updateCounter();
                        });
                        
                        $(document).on('change', '.ad-enable-switch', function() {
                            var adId = $(this).data('ad-id');
                            var isEnabled = $(this).is(':checked');
                            wp.customize('banker_ad_' + adId + '_enable').set(isEnabled);
                        });
                        
                        $(document).on('input', '.ad-code-field', function() {
                            var adId = $(this).data('ad-id');
                            var code = $(this).val();
                            wp.customize('banker_ad_' + adId + '_code').set(code);
                        });
                        
                        $(document).on('change', '.ad-position-select', function() {
                            var adId = $(this).data('ad-id');
                            var position = $(this).val();
                            wp.customize('banker_ad_' + adId + '_position').set(position);
                        });
                    },
                    
                    getNextAvailableId: function() {
                        for (var i = 1; i <= this.maxAds; i++) {
                            if (!$('#ad-item-' + i).length) {
                                return i;
                            }
                        }
                        return this.maxAds + 1;
                    },
                    
                    addAdItem: function(id, data) {
                        data = data || {};
                        
                        var adHtml = this.getAdItemHtml(id, data);
                        $('#ads-list').append(adHtml);
                        
                        // Create customizer settings if they don't exist
                        this.ensureCustomizerSettings(id);
                        
                        this.currentCount++;
                    },
                    
                    removeAdItem: function(id) {
                        $('#ad-item-' + id).remove();
                        
                        // Reset customizer settings
                        wp.customize('banker_ad_' + id + '_enable').set(false);
                        wp.customize('banker_ad_' + id + '_code').set('');
                        wp.customize('banker_ad_' + id + '_position').set('post_start');
                        
                        this.currentCount--;
                    },
                    
                    ensureCustomizerSettings: function(id) {
                        // Ensure settings exist in customizer
                        if (!wp.customize('banker_ad_' + id + '_enable')) {
                            wp.customize.create('banker_ad_' + id + '_enable', false);
                        }
                        if (!wp.customize('banker_ad_' + id + '_code')) {
                            wp.customize.create('banker_ad_' + id + '_code', '');
                        }
                        if (!wp.customize('banker_ad_' + id + '_position')) {
                            wp.customize.create('banker_ad_' + id + '_position', 'post_start');
                        }
                    },
                    
                    getAdItemHtml: function(id, data) {
                        data = data || {};
                        var isEnabled = data.enable || false;
                        var code = data.code || '';
                        var position = data.position || 'post_start';
                        
                        return '<div class="ad-item" id="ad-item-' + id + '">' +
                            '<div class="ad-header">' +
                                '<div class="ad-title">' +
                                    '<span class="ad-number">تبلیغ ' + id + '</span>' +
                                    '<label class="switch">' +
                                        '<input type="checkbox" class="ad-enable-switch" data-ad-id="' + id + '"' + (isEnabled ? ' checked' : '') + '>' +
                                        '<span class="slider"></span>' +
                                    '</label>' +
                                '</div>' +
                                '<button type="button" class="remove-ad" data-ad-id="' + id + '">' +
                                    '<span class="dashicons dashicons-trash"></span>' +
                                '</button>' +
                            '</div>' +
                            '<div class="ad-content">' +
                                '<div class="ad-field">' +
                                    '<label>کد تبلیغاتی:</label>' +
                                    '<textarea class="ad-code-field" data-ad-id="' + id + '" rows="3" placeholder="کد HTML یا JavaScript تبلیغ را وارد کنید...">' + code + '</textarea>' +
                                '</div>' +
                                '<div class="ad-field">' +
                                    '<label>موقعیت نمایش:</label>' +
                                    '<select class="ad-position-select" data-ad-id="' + id + '">' +
                                        '<option value="post_start"' + (position === 'post_start' ? ' selected' : '') + '>ابتدای پست</option>' +
                                        '<option value="paragraph_1"' + (position === 'paragraph_1' ? ' selected' : '') + '>پاراگراف اول</option>' +
                                        '<option value="paragraph_2"' + (position === 'paragraph_2' ? ' selected' : '') + '>پاراگراف دوم</option>' +
                                        '<option value="paragraph_3"' + (position === 'paragraph_3' ? ' selected' : '') + '>پاراگراف سوم</option>' +
                                        '<option value="post_middle"' + (position === 'post_middle' ? ' selected' : '') + '>وسط متن</option>' +
                                        '<option value="post_end"' + (position === 'post_end' ? ' selected' : '') + '>انتهای مطلب</option>' +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                        '</div>';
                    },
                    
                    updateCounter: function() {
                        $('#ads-counter').text(this.currentCount);
                    }
                };
                
                adsManager.init();
            });
            </script>
            
            <style>
            .ads-manager-wrapper {
                margin-top: 10px;
            }
            
            .ads-list {
                margin-bottom: 15px;
            }
            
            .ad-item {
                border: 1px solid #ddd;
                border-radius: 4px;
                margin-bottom: 10px;
                background: #fff;
            }
            
            .ad-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 15px;
                background: #f9f9f9;
                border-bottom: 1px solid #eee;
            }
            
            .ad-title {
                display: flex;
                align-items: center;
                gap: 10px;
            }
            
            .ad-number {
                font-weight: 600;
                color: #333;
            }
            
            .switch {
                position: relative;
                display: inline-block;
                width: 40px;
                height: 20px;
            }
            
            .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }
            
            .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: #ccc;
                transition: .4s;
                border-radius: 20px;
            }
            
            .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 2px;
                bottom: 2px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }
            
            input:checked + .slider {
                background-color: #0073aa;
            }
            
            input:checked + .slider:before {
                transform: translateX(20px);
            }
            
            .remove-ad {
                background: none;
                border: none;
                color: #dc3232;
                cursor: pointer;
                padding: 5px;
                border-radius: 3px;
            }
            
            .remove-ad:hover {
                background: #dc3232;
                color: white;
            }
            
            .ad-content {
                padding: 15px;
            }
            
            .ad-field {
                margin-bottom: 15px;
            }
            
            .ad-field:last-child {
                margin-bottom: 0;
            }
            
            .ad-field label {
                display: block;
                margin-bottom: 5px;
                font-weight: 600;
                color: #333;
            }
            
            .ad-code-field,
            .ad-position-select {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 3px;
                font-size: 13px;
            }
            
            .ad-code-field {
                resize: vertical;
                min-height: 60px;
            }
            
            .ads-controls {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 0;
                border-top: 1px solid #eee;
            }
            
            .add-ad-btn {
                display: flex;
                align-items: center;
                gap: 5px;
            }
            
            .ads-count {
                font-size: 12px;
                color: #666;
            }
            </style>
            <?php
        }
    }
}