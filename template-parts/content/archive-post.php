<?php
$post_id = get_the_ID();
$excerpt = get_the_excerpt();
?>

<article class="bg-white border border-border rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
    
    <div class="flex flex-col md:flex-row">
        
        <!-- Post Thumbnail -->
        <div class="md:w-1/3 lg:w-1/4">
            <a href="<?php the_permalink(); ?>" class="block">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="h-48 md:h-full overflow-hidden">
                        <?php the_post_thumbnail('medium_large', array(
                            'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300',
                            'loading' => 'lazy'
                        )); ?>
                    </div>
                <?php else : ?>
                    <div class="h-48 md:h-full bg-lightBg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 3.6v16.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6V3.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6Z"></path>
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="m3 16 7-3 11 5"></path>
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"></path>
                        </svg>
                    </div>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Post Content -->
        <div class="md:w-2/3 lg:w-3/4 p-6">
            
            <!-- Post Meta -->
            <div class="flex items-center gap-4 text-sm text-grayText mb-3">
                

                
                <!-- Date -->
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 4V2m0 2v2m0-2h-4.5M3 10v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-9H3Z"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 10V6a2 2 0 0 1 2-2h2"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M7 2v4"></path>
                    </svg>
                    <span><?php echo get_the_date('Y/m/d'); ?></span>
                </div>
                

                
            </div>
            
            <!-- Post Title -->
            <h2 class="text-xl font-bold text-black mb-3 line-clamp-2 hover:text-secondary transition-colors">
                <a href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </h2>
            
            <!-- Post Excerpt -->
            <?php if ($excerpt) : ?>
                <p class="text-grayText mb-4 line-clamp-3">
                    <?php echo wp_trim_words($excerpt, 25, '...'); ?>
                </p>
            <?php endif; ?>
            

            
        </div>
        
    </div>
    
</article>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>