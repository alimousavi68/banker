<?php
get_header();
?>

<main class="max-w-[1400px] mx-auto px-4 sm:px-4 lg:px-6 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- ستون راست - محتوای اصلی -->
        <div class="w-full lg:w-3/4 border-e border-border pe-6">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <!-- بخش intro صفحه -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/page-intro'); ?>
            </div>
            
            <!-- بخش محتوای اصلی -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/page-content'); ?>
            </div>
            
            <!-- بخش نظرات (در صورت فعال بودن) -->
            <?php if (comments_open() || get_comments_number()) : ?>
            <div class="mb-8">
                <?php comments_template(); ?>
            </div>
            <?php endif; ?>
            
            <?php endwhile; endif; ?>
            
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