<?php
global $wp_query;

$big = 999999999; // need an unlikely integer
$current_page = max(1, get_query_var('paged'));
$total_pages = $wp_query->max_num_pages;

if ($total_pages > 1) :
?>

<div class="bg-white border border-border rounded-lg p-6">
    
    <!-- Pagination Links -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Previous/Next Navigation -->
        <div class="flex items-center gap-2">
            
            <!-- Previous Page -->
            <?php if ($current_page > 1) : ?>
                <a href="<?php echo get_pagenum_link($current_page - 1); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-lightBg hover:bg-secondary hover:text-white transition-colors rounded-lg text-black font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M18 12H6m6-6-6 6 6 6"></path>
                    </svg>
                    صفحه قبل
                </a>
            <?php else : ?>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M18 12H6m6-6-6 6 6 6"></path>
                    </svg>
                    صفحه قبل
                </span>
            <?php endif; ?>
            
            <!-- Next Page -->
            <?php if ($current_page < $total_pages) : ?>
                <a href="<?php echo get_pagenum_link($current_page + 1); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-lightBg hover:bg-secondary hover:text-white transition-colors rounded-lg text-black font-medium">
                    صفحه بعد
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6 12h12m-6-6 6 6-6 6"></path>
                    </svg>
                </a>
            <?php else : ?>
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-400 rounded-lg cursor-not-allowed">
                    صفحه بعد
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6 12h12m-6-6 6 6-6 6"></path>
                    </svg>
                </span>
            <?php endif; ?>
            
        </div>
        
        <!-- Page Numbers -->
        <div class="flex items-center gap-1">
            
            <?php
            // Calculate page range
            $range = 2; // Number of pages to show on each side of current page
            $start_page = max(1, $current_page - $range);
            $end_page = min($total_pages, $current_page + $range);
            
            // Show first page if not in range
            if ($start_page > 1) :
            ?>
                <a href="<?php echo get_pagenum_link(1); ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border hover:bg-secondary hover:text-white hover:border-secondary transition-colors <?php echo ($current_page == 1) ? 'bg-secondary text-white border-secondary' : 'bg-white text-black'; ?>">
                    1
                </a>
                <?php if ($start_page > 2) : ?>
                    <span class="px-2 text-grayText">...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Page range -->
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <a href="<?php echo get_pagenum_link($i); ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border hover:bg-secondary hover:text-white hover:border-secondary transition-colors <?php echo ($current_page == $i) ? 'bg-secondary text-white border-secondary' : 'bg-white text-black'; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
            
            <!-- Show last page if not in range -->
            <?php if ($end_page < $total_pages) : ?>
                <?php if ($end_page < $total_pages - 1) : ?>
                    <span class="px-2 text-grayText">...</span>
                <?php endif; ?>
                <a href="<?php echo get_pagenum_link($total_pages); ?>" class="w-10 h-10 flex items-center justify-center rounded-lg border border-border hover:bg-secondary hover:text-white hover:border-secondary transition-colors <?php echo ($current_page == $total_pages) ? 'bg-secondary text-white border-secondary' : 'bg-white text-black'; ?>">
                    <?php echo $total_pages; ?>
                </a>
            <?php endif; ?>
            
        </div>
        
    </div>
    
</div>

<?php endif; ?>