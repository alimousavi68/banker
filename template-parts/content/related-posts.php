<?php
$post_id = get_the_ID();
$tags = wp_get_post_tags($post_id);

if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) {
        $tag_ids[] = $individual_tag->term_id;
    }
    
    $args = array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post_id),
        'posts_per_page' => 4,
        'caller_get_posts' => 1,
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $related_posts = new WP_Query($args);
    
    if ($related_posts->have_posts()) :
?>

<div class="bg-white border border-border -lg p-6">
    
    <!-- Section Header -->
    <div class="border-b border-border pb-4 mb-6">
        <h2 class="text-xl font-bold text-black flex items-center gap-3">
            <div class="w-1 h-6 bg-secondary "></div>
            اخبار مرتبط
        </h2>
        <p class="text-grayText text-sm mt-2">مطالب مشابه که ممکن است برای شما جالب باشد</p>
    </div>
    
    <!-- Related Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <?php while ($related_posts->have_posts()) : $related_posts->the_post(); ?>
            <article class="group">
                <a href="<?php the_permalink(); ?>" class="block">
                    
                    <div class="flex gap-4">
                        
                        <!-- Post Thumbnail -->
                        <div class="flex-shrink-0 w-24 h-24 md:w-28 md:h-28">
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="w-full h-full -lg overflow-hidden">
                                    <?php the_post_thumbnail('medium', array(
                                        'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300',
                                        'loading' => 'lazy'
                                    )); ?>
                                </div>
                            <?php else : ?>
                                <div class="w-full h-full bg-lightBg -lg flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText">
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 3.6v16.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6V3.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6Z"></path>
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="m3 16 7-3 11 5"></path>
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Post Content -->
                        <div class="flex-1 min-w-0">
                            
                            <!-- Post Title -->
                            <h3 class="text-base font-semibold text-black group-hover:text-secondary transition-colors line-clamp-2 mb-2">
                                <?php the_title(); ?>
                            </h3>
                            
                            <!-- Post Excerpt -->
                            <p class="text-sm text-grayText line-clamp-2 mb-3">
                                <?php echo wp_trim_words(get_the_excerpt(), 15, '...'); ?>
                            </p>
                            
                            <!-- Post Meta -->
                            <div class="flex items-center gap-4 text-xs text-grayText">
                                
                                <!-- Date -->
                                <div class="flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 4V2m0 2v2m0-2h-4.5M3 10v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-9H3Z"></path>
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 10V6a2 2 0 0 1 2-2h2"></path>
                                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M7 2v4"></path>
                                    </svg>
                                    <span><?php echo get_the_date('Y/m/d'); ?></span>
                                </div>
                                
                                <!-- Category -->
                                <?php 
                                $category = get_the_category();
                                if (!empty($category)) :
                                ?>
                                    <div class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a2 2 0 0 1 2 2v14l-6-4-6 4V5a2 2 0 0 1 2-2Z"></path>
                                        </svg>
                                        <span><?php echo esc_html($category[0]->name); ?></span>
                                    </div>
                                <?php endif; ?>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </a>
            </article>
        <?php endwhile; ?>
        
    </div>
    
    <!-- View More Button -->
    <div class="border-t border-border pt-6 mt-6 text-center">
        <a 
            href="<?php echo home_url('/news'); ?>" 
            class="inline-flex items-center gap-2 px-6 py-3 bg-secondary text-white -lg hover:bg-opacity-90 transition-colors"
        >
            <span>مشاهده همه اخبار</span>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6 12h12m0 0-6-6m6 6-6 6"></path>
            </svg>
        </a>
    </div>
    
</div>

<?php 
    endif;
    wp_reset_postdata();
}
?>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>