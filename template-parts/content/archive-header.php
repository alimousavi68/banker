<?php
$archive_title = get_the_archive_title();
$archive_description = get_the_archive_description();
?>

<div class="bg-white border border-border rounded-lg p-6 mb-6">
    
    <!-- Archive Title -->
    <div class="border-b border-border pb-4 mb-4">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-black flex items-center gap-3">
                <div class="w-1 h-8 bg-secondary rounded"></div>
                <?php echo $archive_title; ?>
            </h1>
            
            <!-- Archive Stats -->
            <div class="flex items-center gap-6 text-sm text-grayText">
        
        <!-- Total Posts Count -->
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a2 2 0 0 1 2 2v14l-6-4-6 4V5a2 2 0 0 1 2-2Z"></path>
            </svg>
            <span>
                <?php
                global $wp_query;
                $total_posts = $wp_query->found_posts;
                echo $total_posts . ' مطلب';
                ?>
            </span>
        </div>
        
        <!-- Current Page Info -->
        <?php if (is_paged()) : ?>
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 21.4V2.6a.6.6 0 0 1 .6-.6h11.9c.331 0 .6.269.6.6v18.8a.6.6 0 0 1-.6.6H4.6a.6.6 0 0 1-.6-.6Z"></path>
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 6h4M8 10h4"></path>
                </svg>
                <span>صفحه <?php echo get_query_var('paged') ? get_query_var('paged') : 1; ?></span>
            </div>
        <?php endif; ?>
        
        <!-- Archive Type -->
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M3 12h18M3 17h18"></path>
            </svg>
            <span>
                <?php
                if (is_category()) {
                    echo 'دسته‌بندی';
                } elseif (is_tag()) {
                    echo 'برچسب';
                } elseif (is_author()) {
                    echo 'نویسنده';
                } elseif (is_date()) {
                    echo 'آرشیو تاریخی';
                } else {
                    echo 'آرشیو';
                }
                ?>
            </span>
            </div>
            
        </div>
        
        <?php if ($archive_description) : ?>
            <div class="text-grayText mt-3">
                <?php echo $archive_description; ?>
            </div>
        <?php endif; ?>
    </div>
    
</div>