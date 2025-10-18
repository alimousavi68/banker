/**
 * Post Settings Customizer JavaScript
 * 
 * Enhances the customizer interface for post settings
 */

(function($) {
    'use strict';

    // Wait for customizer to be ready
    wp.customize.bind('ready', function() {
        
        // Add custom styling to post settings panel
        var postSettingsPanel = $('#accordion-panel-banker_post_settings_panel');
        if (postSettingsPanel.length) {
            postSettingsPanel.find('.panel-title').prepend('<span class="dashicons dashicons-admin-post" style="margin-left: 5px;"></span>');
        }

        // Add icons to sections
        var sections = {
            'banker_post_prefix_section': 'dashicons-editor-alignleft',
            'banker_post_suffix_section': 'dashicons-editor-alignright',
            'banker_ad_management_section': 'dashicons-money-alt'
        };

        $.each(sections, function(sectionId, iconClass) {
            var section = $('#accordion-section-' + sectionId);
            if (section.length) {
                section.find('.accordion-section-title').prepend('<span class="dashicons ' + iconClass + '" style="margin-left: 5px;"></span>');
            }
        });

        // Add help text for ad positions
        var adPositionHelp = {
            'post_start': 'تبلیغ در ابتدای پست، قبل از اولین پاراگراف نمایش داده می‌شود',
            'paragraph_1': 'تبلیغ بعد از پاراگراف اول نمایش داده می‌شود',
            'paragraph_2': 'تبلیغ بعد از پاراگراف دوم نمایش داده می‌شود',
            'paragraph_3': 'تبلیغ بعد از پاراگراف سوم نمایش داده می‌شود',
            'post_middle': 'تبلیغ در وسط متن (بعد از نیمی از پاراگراف‌ها) نمایش داده می‌شود',
            'post_end': 'تبلیغ در انتهای پست، بعد از آخرین پاراگراف نمایش داده می‌شود'
        };

        // Add help text to ad position selects
        for (var i = 1; i <= 10; i++) {
            (function(index) {
                var positionControl = wp.customize.control('banker_ad_' + index + '_position');
                if (positionControl) {
                    positionControl.container.find('select').on('change', function() {
                        var selectedValue = $(this).val();
                        var helpText = adPositionHelp[selectedValue] || '';
                        
                        // Remove existing help text
                        $(this).siblings('.position-help').remove();
                        
                        // Add new help text
                        if (helpText) {
                            $(this).after('<p class="position-help" style="font-size: 11px; color: #666; margin: 5px 0 0 0; font-style: italic;">' + helpText + '</p>');
                        }
                    }).trigger('change');
                }
            })(i);
        }

        // Add preview functionality
        function addPreviewButton(controlId, previewText) {
            var control = wp.customize.control(controlId);
            if (control) {
                var textarea = control.container.find('textarea');
                if (textarea.length) {
                    var previewBtn = $('<button type="button" class="button button-secondary" style="margin-top: 5px;">پیش‌نمایش</button>');
                    
                    previewBtn.on('click', function(e) {
                        e.preventDefault();
                        var content = textarea.val();
                        if (content.trim()) {
                            var previewWindow = window.open('', 'preview', 'width=600,height=400,scrollbars=yes');
                            previewWindow.document.write('<html><head><title>پیش‌نمایش</title></head><body style="font-family: Tahoma, Arial; direction: rtl; padding: 20px;"><h3>' + previewText + '</h3><div style="border: 1px solid #ddd; padding: 15px; background: #f9f9f9;">' + content + '</div></body></html>');
                            previewWindow.document.close();
                        } else {
                            alert('لطفاً ابتدا محتوایی وارد کنید.');
                        }
                    });
                    
                    textarea.after(previewBtn);
                }
            }
        }

        // Add preview buttons for prefix and suffix
        addPreviewButton('banker_post_prefix_content', 'متن پیش‌فرض ابتدای پست');
        addPreviewButton('banker_post_suffix_content', 'متن انتهای پست');

        // Add preview buttons for ad codes
        for (var i = 1; i <= 10; i++) {
            addPreviewButton('banker_ad_' + i + '_code', 'کد تبلیغ ' + i);
        }

        // Add validation for ad codes
        for (var i = 1; i <= 10; i++) {
            (function(index) {
                var codeControl = wp.customize.control('banker_ad_' + index + '_code');
                if (codeControl) {
                    codeControl.container.find('textarea').on('blur', function() {
                        var code = $(this).val().trim();
                        var warningDiv = $(this).siblings('.code-warning');
                        
                        // Remove existing warning
                        warningDiv.remove();
                        
                        if (code && !code.match(/<[^>]+>/)) {
                            // Doesn't look like HTML
                            $(this).after('<div class="code-warning" style="color: #d63638; font-size: 11px; margin-top: 5px;">⚠️ این کد شبیه HTML یا JavaScript نیست. لطفاً از صحت آن اطمینان حاصل کنید.</div>');
                        }
                    });
                }
            })(i);
        }

        // Add collapsible functionality for ad sections
        function makeAdSectionsCollapsible() {
            for (var i = 1; i <= 10; i++) {
                (function(index) {
                    var enableControl = wp.customize.control('banker_ad_' + index + '_enable');
                    var codeControl = wp.customize.control('banker_ad_' + index + '_code');
                    var positionControl = wp.customize.control('banker_ad_' + index + '_position');
                    
                    if (enableControl && codeControl && positionControl) {
                        // Create a wrapper for this ad group
                        var wrapper = $('<div class="ad-group-wrapper" style="border: 1px solid #ddd; margin: 10px 0; padding: 10px; border-radius: 4px;"></div>');
                        var header = $('<div class="ad-group-header" style="font-weight: bold; margin-bottom: 10px; cursor: pointer;">📢 تبلیغ ' + index + ' <span class="toggle-icon" style="float: left;">▼</span></div>');
                        
                        enableControl.container.before(wrapper);
                        wrapper.append(header);
                        wrapper.append(enableControl.container);
                        wrapper.append(codeControl.container);
                        wrapper.append(positionControl.container);
                        
                        // Toggle functionality
                        header.on('click', function() {
                            var content = wrapper.find('.customize-control').not(':first');
                            var icon = $(this).find('.toggle-icon');
                            
                            if (content.is(':visible')) {
                                content.hide();
                                icon.text('▶');
                            } else {
                                content.show();
                                icon.text('▼');
                            }
                        });
                        
                        // Initially collapse if not enabled
                        if (!wp.customize('banker_ad_' + index + '_enable').get()) {
                            wrapper.find('.customize-control').not(':first').hide();
                            header.find('.toggle-icon').text('▶');
                        }
                    }
                })(i);
            }
        }

        // Apply collapsible functionality after a short delay
        setTimeout(makeAdSectionsCollapsible, 500);

        // Add custom CSS for better styling
        $('<style>')
            .prop('type', 'text/css')
            .html(`
                .ad-group-wrapper {
                    background: #f8f9fa;
                }
                .ad-group-wrapper:hover {
                    background: #f1f3f4;
                }
                .ad-group-header {
                    user-select: none;
                }
                .ad-group-header:hover {
                    color: #0073aa;
                }
                .position-help {
                    background: #fff3cd;
                    border: 1px solid #ffeaa7;
                    border-radius: 3px;
                    padding: 5px 8px;
                }
                .code-warning {
                    background: #f8d7da;
                    border: 1px solid #f5c6cb;
                    border-radius: 3px;
                    padding: 5px 8px;
                }
            `)
            .appendTo('head');
    });

})(jQuery);