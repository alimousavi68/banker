<?php
$page_id = get_the_ID();
$content = get_the_content();
$last_modified = get_the_modified_date('Y/m/d - H:i');
?>

<article class="bg-white border-border border-b rounded-lg px-1 lg:px-2">
    
    <!-- Main Content -->
    <div class="prose prose-lg max-w-none">
        <div class="text-black leading-relaxed space-y-4">
            <?php
            // Apply content filters and display
            echo apply_filters('the_content', $content);
            ?>
        </div>
    </div>
    
    <!-- Last Updated Date -->
    <div class="mt-6 pt-4 border-t border-border">
        <div class="flex items-center gap-2 text-sm text-grayText">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h6"></path>
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"></path>
            </svg>
            <span>آخرین بروزرسانی: <?php echo $last_modified; ?></span>
        </div>
    </div>
    
    <!-- Content Footer -->
    <div class="border-t border-border pt-6 mt-6">
        <div class="flex flex-wrap items-center justify-center gap-4">
            
            <!-- Page Actions -->
            <div class="flex items-center gap-3">
                
                <!-- Print Button -->
                <button onclick="window.print()" class="flex items-center gap-2 px-3 py-2 text-sm text-grayText hover:text-black border border-border rounded-md hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17.5 7.5h.5a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2h-.5m-11 0H6a2 2 0 0 1-2-2v-6a2 2 0 0 1 2-2h.5m0 0V5a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2.5m-10 0h10M8 15h8v2a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-2Z"></path>
                    </svg>
                    <span>چاپ</span>
                </button>
                
                <!-- Share Button -->
                <button onclick="navigator.share ? navigator.share({title: '<?php echo esc_js(get_the_title()); ?>', url: '<?php echo esc_js(get_permalink()); ?>'}) : copyToClipboard('<?php echo esc_js(get_permalink()); ?>')" class="flex items-center gap-2 px-3 py-2 text-sm text-grayText hover:text-black border border-border rounded-md hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M20 12v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6m16-5-8 8-8-8m8 0V3"></path>
                    </svg>
                    <span>اشتراک‌گذاری</span>
                </button>
                
            </div>
            
        </div>
    </div>
    
</article>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a simple notification
        const notification = document.createElement('div');
        notification.textContent = 'لینک کپی شد!';
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 2000);
    });
}
</script>