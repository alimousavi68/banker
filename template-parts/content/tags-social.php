<?php
$post_id = get_the_ID();
$tags = get_the_tags($post_id);
$post_url = get_permalink($post_id);
$post_title = get_the_title();
$post_excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
?>

<div class="bg-white border border-border -lg p-6">
    
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
        
        <!-- Tags Section -->
        <div class="flex-1">
            <?php if ($tags && !is_wp_error($tags)): ?>
                <div class="flex items-center gap-3 mb-4 lg:mb-0">
                    <h3 class="text-lg font-semibold text-black flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                            <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M8 3h8a2 2 0 0 1 2 2v14l-6-4-6 4V5a2 2 0 0 1 2-2Z"></path>
                        </svg>
                        برچسب‌ها:
                    </h3>
                </div>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($tags as $tag): ?>
                        <a 
                            href="<?php echo get_tag_link($tag->term_id); ?>" 
                            class="inline-flex items-center px-3 py-1 bg-lightBg border border-border -full text-sm text-grayText hover:bg-secondary hover:text-white hover:border-secondary transition-all duration-200"
                        >
                            <span>#<?php echo esc_html($tag->name); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-grayText text-sm">
                    هیچ برچسبی برای این پست تعریف نشده است.
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Social Share Section -->
        <div class="lg:border-r lg:border-border lg:pr-6">
            <h3 class="text-lg font-semibold text-black mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M18 22a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 22a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"></path>
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="m15.5 6.5-7 4M8.5 17.5l7-4"></path>
                </svg>
                اشتراک‌گذاری:
            </h3>
            
            <div class="flex items-center gap-3">
                
                <!-- Twitter Share -->
                <a 
                    href="https://twitter.com/intent/tweet?text=<?php echo urlencode($post_title); ?>&url=<?php echo urlencode($post_url); ?>" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="flex items-center justify-center w-10 h-10 bg-[#1DA1F2] text-white -full hover:bg-[#1a91da] transition-colors"
                    title="اشتراک در توییتر"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                    </svg>
                </a>
                
                <!-- Telegram Share -->
                <a 
                    href="https://t.me/share/url?url=<?php echo urlencode($post_url); ?>&text=<?php echo urlencode($post_title); ?>" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="flex items-center justify-center w-10 h-10 bg-[#0088cc] text-white -full hover:bg-[#0077b5] transition-colors"
                    title="اشتراک در تلگرام"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                    </svg>
                </a>
                
                <!-- Facebook Share -->
                <a 
                    href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($post_url); ?>" 
                    target="_blank" 
                    rel="noopener noreferrer"
                    class="flex items-center justify-center w-10 h-10 bg-[#1877F2] text-white -full hover:bg-[#166fe5] transition-colors"
                    title="اشتراک در فیسبوک"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                
                <!-- Instagram Share (Copy Link) -->
                <button 
                    onclick="copyToClipboard('<?php echo esc_js($post_url); ?>')" 
                    class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-[#833AB4] via-[#FD1D1D] to-[#F77737] text-white -full hover:opacity-90 transition-opacity"
                    title="کپی لینک برای اینستاگرام"
                >
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </button>
                
                <!-- Copy Link Button -->
                <button 
                    onclick="copyToClipboard('<?php echo esc_js($post_url); ?>')" 
                    class="flex items-center justify-center w-10 h-10 bg-grayText text-white -full hover:bg-black transition-colors"
                    title="کپی لینک"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M14 11.998C14 9.506 11.683 7 8.857 7H7.143C4.303 7 2 9.238 2 11.998c0 2.378 1.71 4.368 4 4.873a5.3 5.3 0 0 0 1.143.129"></path>
                        <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M10 11.998C10 14.49 12.317 17 15.143 17h1.714C19.697 17 22 14.762 22 11.998c0-2.378-1.71-4.368-4-4.873A5.3 5.3 0 0 0 16.857 7"></path>
                    </svg>
                </button>
                
            </div>
        </div>
        
    </div>
    
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2  shadow-lg z-50';
        toast.textContent = 'لینک کپی شد!';
        document.body.appendChild(toast);
        
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 2000);
    }).catch(function(err) {
        console.error('خطا در کپی کردن: ', err);
    });
}
</script>