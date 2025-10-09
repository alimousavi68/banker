<?php
get_header();
?>

<main class="max-w-[1400px] mx-auto px-4 sm:px-4 lg:px-6 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- ستون راست - محتوای اصلی -->
        <div class="w-full lg:w-3/4  border-e border-border pe-6">
        
            
            <!-- بخش intro -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/intro'); ?>
            </div>
            
            <!-- بخش محتوای اصلی -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/main-content'); ?>
            </div>
            
            <!-- بخش تگ‌ها و اشتراک‌گذاری -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/tags-social'); ?>
            </div>
            
            <!-- بخش اخبار مرتبط -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/related-posts'); ?>
            </div>
            
            <!-- بخش نظرات -->
            <div class="mb-8">
                <?php
                if (comments_open() || get_comments_number()) {
                    comments_template();
                }
                ?>
            </div>
            
        </div>
        
        <!-- ستون چپ - سایدبار -->
        <div class="w-full lg:w-1/4">
            <div class="lg:sticky lg:top-8">
                <?php
                if (is_active_sidebar('primary-sidebar')) {
                    dynamic_sidebar('primary-sidebar');
                } else {
                    // Default sidebar content
                    get_template_part('template-parts/sidebar/default-sidebar');
                }
                ?>
            </div>
        </div>
        
    </div>
</main>

<?php
get_footer();
?>