<?php
/**
 * WordPress TinyMCE Editor Control for Customizer
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
    return;
}

class WP_Customize_TinyMCE_Control extends WP_Customize_Control {
    
    public $type = 'tinymce_editor';
    
    public function enqueue() {
        wp_enqueue_script( 'wp-tinymce' );
        wp_enqueue_editor();
        wp_enqueue_media();
        wp_enqueue_style( 'editor-buttons' );
    }
    
    public function render_content() {
        $input_id = '_customize-input-' . $this->id;
        $editor_id = 'banker_editor_' . str_replace( array( '[', ']' ), array( '_', '' ), $this->id );
        ?>
        <label class="customize-control-title">
            <?php echo esc_html( $this->label ); ?>
        </label>
        <?php if ( ! empty( $this->description ) ) : ?>
            <span class="description customize-control-description"><?php echo $this->description; ?></span>
        <?php endif; ?>
        
        <div class="customize-control-content">
            <textarea class="wp-editor-area" rows="12" cols="40" name="<?php echo esc_attr( $input_id ); ?>" id="<?php echo esc_attr( $editor_id ); ?>"><?php echo esc_textarea( $this->value() ); ?></textarea>
            <input type="hidden" id="<?php echo esc_attr( $input_id ); ?>" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>" />
        </div>
        
        <script type="text/javascript">
        jQuery(function($) {
            var editorId = '<?php echo esc_js( $editor_id ); ?>';
            var inputId = '<?php echo esc_js( $input_id ); ?>';

            function initEditor() {
                if ( typeof wp === 'undefined' || ! wp.editor || ! wp.editor.getDefaultSettings ) {
                    return;
                }

                // Initialize using core to build clean UI (adds wrap, tabs, media buttons)
                wp.editor.initialize(editorId, {
                    tinymce: {
                        wpautop: true,
                        plugins: 'charmap colorpicker hr lists paste tabfocus textcolor fullscreen wordpress wpautoresize wpeditimage wpemoji wpgallery wplink wptextpattern',
                        toolbar1: 'formatselect,bold,italic,underline,strikethrough,blockquote,|,alignleft,aligncenter,alignright,|,bullist,numlist,|,link,unlink,|,undo,redo,|,wp_adv',
                        toolbar2: 'forecolor,backcolor,removeformat',
                        setup: function(editor) {
                            // Sync to Customizer setting
                            editor.on('change keyup NodeChange', function() {
                                var content = editor.getContent();
                                $('#' + inputId).val(content).trigger('change');
                            });
                            editor.on('init', function() {
                                var initial = $('#' + inputId).val();
                                if ( initial ) { editor.setContent(initial); }
                            });
                        }
                    },
                    quicktags: {
                        buttons: 'strong,em,link,del,ins,code,ul,ol,li,close'
                    },
                    mediaButtons: true
                });

                // When switching to Text tab, keep values in sync
                $(document).on('input', '#' + editorId, function() {
                    $('#' + inputId).val($(this).val()).trigger('change');
                });
            }

            // Delay until TinyMCE + settings are ready
            if ( window.tinymce ) { initEditor(); }
            else {
                var tries = 0;
                var timer = setInterval(function(){
                    tries++;
                    if ( window.tinymce || tries > 50 ) { clearInterval(timer); initEditor(); }
                }, 100);
            }
        });
        </script>
        <?php
    }
}