<?php
get_header();
?>

<main class="max-w-[1400px] mx-auto px-4 sm:px-4 lg:px-6 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
       
        <!-- ستون راست - محتوای اصلی -->
        <div class="w-full lg:w-3/4 border-border  lg:border-e lg:pe-6">
            
            <!-- بخش عنوان آرشیو -->
            <div class="mb-8">
                <?php get_template_part('template-parts/content/archive-header'); ?>
            </div>
            
            <!-- بخش لیست پست‌ها -->
            <div class="space-y-6">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <div class="mb-6">
                            <?php get_template_part('template-parts/content/archive-post'); ?>
                        </div>
                    <?php endwhile; ?>
                    
                    <!-- بخش صفحه‌بندی -->
                    <div class="mt-12">
                        <?php get_template_part('template-parts/content/pagination'); ?>
                    </div>
                    
                <?php else : ?>
                    <div class="text-center py-12">
                        <div class="bg-lightBg rounded-lg p-8">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="mx-auto mb-4 text-grayText">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <h3 class="text-xl font-bold text-black mb-2">هیچ مطلبی یافت نشد</h3>
                            <p class="text-grayText">در این بخش هنوز مطلبی منتشر نشده است.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            
        </div>

         <!-- ستون چپ - سایدبار -->
        <div class="w-full lg:w-1/4 ">
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