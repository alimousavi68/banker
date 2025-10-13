<?php
$search_query = get_search_query();
global $wp_query;
$total_results = $wp_query->found_posts;
?>

<div class="bg-white border border-border rounded-lg p-6 mb-6">
    
    <!-- Search Form -->
    <div class="border-b border-border pb-6 mb-6">
        <h1 class="text-2xl font-bold text-black flex items-center gap-3 mb-4">
            <div class="w-1 h-8 bg-secondary rounded"></div>
            جستجو در سایت
        </h1>
        
        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="relative">
            <div class="flex gap-3">
                <div class="flex-1 relative">
                    <input 
                        type="search" 
                        name="s" 
                        value="<?php echo esc_attr($search_query); ?>" 
                        placeholder="کلمه کلیدی خود را وارد کنید..."
                        class="w-full px-4 py-3 pr-12 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent text-black placeholder-grayText"
                        required
                    >
                    <div class="absolute right-4 top-1/2 transform -translate-y-1/2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition-colors font-medium flex items-center gap-2"
                    style="background-color: #CD3737; color: white;"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    جستجو
                </button>
            </div>
        </form>
    </div>
    
    <!-- Search Results Info -->
    <?php if ($search_query) : ?>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            
            <!-- Search Query and Results Count -->
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-secondary">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span class="font-medium">نتایج جستجو برای:</span>
                    <span class="font-bold text-secondary">"<?php echo esc_html($search_query); ?>"</span>
                </div>
                
                <div class="text-sm text-grayText">
                    <?php if ($total_results > 0) : ?>
                        <?php echo $total_results; ?> نتیجه یافت شد
                    <?php else : ?>
                        هیچ نتیجه‌ای یافت نشد
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Page Info -->
            <?php if ($total_results > 0 && is_paged()) : ?>
                <div class="flex items-center gap-2 text-sm text-grayText">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M4 21.4V2.6a.6.6 0 0 1 .6-.6h11.9c.331 0 .6.269.6.6v18.8a.6.6 0 0 1-.6.6H4.6a.6.6 0 0 1-.6-.6Z"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 6h4M8 10h4"></path>
                    </svg>
                    <span>صفحه <?php echo get_query_var('paged') ? get_query_var('paged') : 1; ?></span>
                </div>
            <?php endif; ?>
            
        </div>
    <?php endif; ?>
    
</div>