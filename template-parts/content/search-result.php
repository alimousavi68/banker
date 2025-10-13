<?php
$post_id = get_the_ID();
$excerpt = get_the_excerpt();
$category = get_the_category();
$search_query = get_search_query();

// Function to highlight search terms
if (!function_exists('highlight_search_terms')) {
    function highlight_search_terms($text, $search_query) {
    if (empty($search_query)) return $text;
    
    $search_terms = explode(' ', $search_query);
    foreach ($search_terms as $term) {
        if (strlen(trim($term)) > 2) {
            $text = preg_replace('/(' . preg_quote(trim($term), '/') . ')/iu', '<mark class="bg-yellow-200 text-black px-1 rounded">$1</mark>', $text);
        }
    }
    return $text;
    }
}
?>

<article class="bg-white border border-border rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
    
    <div class="flex flex-col md:flex-row">
        
        <!-- Post Thumbnail -->
        <div class="md:w-1/4 lg:w-1/5">
            <a href="<?php the_permalink(); ?>" class="block">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="h-32 md:h-full overflow-hidden">
                        <?php the_post_thumbnail('medium', array(
                            'class' => 'w-full h-full object-cover hover:scale-105 transition-transform duration-300',
                            'loading' => 'lazy'
                        )); ?>
                    </div>
                <?php else : ?>
                    <div class="h-32 md:h-full bg-lightBg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 3.6v16.8a.6.6 0 0 1-.6.6H3.6a.6.6 0 0 1-.6-.6V3.6a.6.6 0 0 1 .6-.6h16.8a.6.6 0 0 1 .6.6Z"></path>
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="m3 16 7-3 11 5"></path>
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M16 10a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"></path>
                        </svg>
                    </div>
                <?php endif; ?>
            </a>
        </div>
        
        <!-- Post Content -->
        <div class="md:w-3/4 lg:w-4/5 p-6">
            
            <!-- Post Meta -->
            <div class="flex items-center gap-4 text-sm text-grayText mb-3">
                
                <!-- Category -->
                <?php if (!empty($category)) : ?>
                    <div class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a2 2 0 0 1 2 2v14l-6-4-6 4V5a2 2 0 0 1 2-2Z"></path>
                        </svg>
                        <a href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>" class="hover:text-secondary transition-colors">
                            <?php echo esc_html($category[0]->name); ?>
                        </a>
                    </div>
                <?php endif; ?>
                
                <!-- Date -->
                <div class="flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M15 4V2m0 2v2m0-2h-4.5M3 10v9a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-9H3Z"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 10V6a2 2 0 0 1 2-2h2"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M7 2v4"></path>
                    </svg>
                    <span><?php echo get_the_date('Y/m/d'); ?></span>
                </div>
                

                
                <!-- Search Match Indicator -->
                <div class="flex items-center gap-1 text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>نتیجه جستجو</span>
                </div>
                
            </div>
            
            <!-- Post Title with Highlighted Search Terms -->
            <h2 class="text-xl font-bold text-black mb-3 line-clamp-2 hover:text-secondary transition-colors">
                <a href="<?php the_permalink(); ?>">
                    <?php echo highlight_search_terms(get_the_title(), $search_query); ?>
                </a>
            </h2>
            
            <!-- Post Excerpt with Highlighted Search Terms -->
            <?php if ($excerpt) : ?>
                <p class="text-grayText mb-4 line-clamp-3">
                    <?php echo highlight_search_terms(wp_trim_words($excerpt, 30, '...'), $search_query); ?>
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