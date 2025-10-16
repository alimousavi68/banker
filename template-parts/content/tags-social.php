<?php
$post_id = get_the_ID();
$tags = get_the_tags($post_id);
$post_url = get_permalink($post_id);
$short_url = home_url('?p=' . $post_id); // Short URL with post ID
$post_title = get_the_title();
$post_excerpt = wp_trim_words(get_the_excerpt(), 20, '...');
?>


<!-- Tags and Social Section -->
<div class="flex flex-row justify-between gap-3 border-t border-b border-border my-8 mb-8 py-3">
    
<div class="flex flex-wrap gap-2"></div>
<!-- Tags Section -->
    <?php if ($tags && !is_wp_error($tags)): ?>
        
            <?php foreach ($tags as $tag): ?>
                <a 
                    href="<?php echo get_tag_link($tag->term_id); ?>" 
                    class="inline-flex items-center px-3 py-1 bg-lightBg border border-border rounded-full text-sm text-grayText hover:bg-secondary hover:text-white hover:border-secondary transition-all duration-200"
                >
                    <span>#<?php echo esc_html($tag->name); ?></span>
                </a>
            <?php endforeach; ?>
        
    <?php endif; ?>
    </div>

    <!-- Left Side - Copy Link Button and Social Icons -->
    <div class="flex items-center gap-3">
        
        <!-- Copy Link Button -->
        <button 
            onclick="copyToClipboard('<?php echo esc_js($short_url); ?>')" 
            class="inline-flex items-center gap-2 px-3 py-2 bg-lightBg border border-border rounded-full text-sm text-grayText  hover:text-white hover:bg-[#0077b5] transition-all duration-200"
            title="کپی لینک"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M14 11.998C14 9.506 11.683 7 8.857 7H7.143C4.303 7 2 9.238 2 11.998c0 2.378 1.71 4.368 4 4.873a5.3 5.3 0 0 0 1.143.129"></path>
                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M10 11.998C10 14.49 12.317 17 15.143 17h1.714C19.697 17 22 14.762 22 11.998c0-2.378-1.71-4.368-4-4.873A5.3 5.3 0 0 0 16.857 7"></path>
            </svg>
           <span> کپی لینک</span>
        </button>
        
        <!-- Print Button -->
        <button 
            onclick="window.print()" 
            class="flex items-center justify-center w-10 h-10 text-primary hover:text-primaryDark hover:bg-gray-100 transition-colors rounded-md"
            title="پرینت پست"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#0077b5" viewBox="0 0 24 24">
                <path d="M19 8H5c-1.66 0-3 1.34-3 3v6h4v4h12v-4h4v-6c0-1.66-1.34-3-3-3zm-3 11H8v-5h8v5zm3-7c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm-1-9H6v4h12V3z"/>
            </svg>
        </button>
        
        <!-- Instagram Share -->
        <button 
            onclick="copyToClipboard('<?php echo esc_js($short_url); ?>')" 
            class="flex items-center justify-center w-10 h-10 text-primary hover:text-primaryDark hover:bg-gray-100 transition-colors rounded-md"
            title="اشتراک در اینستاگرام"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#0077b5">
                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
            </svg>
        </button>
        
        <!-- Telegram Share -->
        <a 
            href="https://t.me/share/url?url=<?php echo urlencode($short_url); ?>&text=<?php echo urlencode($post_title); ?>" 
            target="_blank" 
            rel="noopener noreferrer"
            class="flex items-center justify-center w-10 h-10 text-primary hover:text-primaryDark hover:bg-gray-100 transition-colors rounded-md"
            title="اشتراک در تلگرام"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#0077b5">
                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
            </svg>
        </a>
        
        <!-- X (Twitter) Share -->
        <a 
            href="https://twitter.com/intent/tweet?text=<?php echo urlencode($post_title); ?>&url=<?php echo urlencode($short_url); ?>" 
            target="_blank" 
            rel="noopener noreferrer"
            class="flex items-center justify-center w-10 h-10 text-primary hover:text-primaryDark hover:bg-gray-100 transition-colors rounded-md"
            title="اشتراک در X (توییتر)"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#0077b5">
                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
        </a>
        
        <!-- WhatsApp Share -->
        <a 
            href="https://wa.me/?text=<?php echo urlencode($post_title . ' ' . $short_url); ?>" 
            target="_blank" 
            rel="noopener noreferrer"
            class="flex items-center justify-center w-10 h-10 text-primary hover:text-primaryDark hover:bg-gray-100 transition-colors rounded-md"
            title="اشتراک در واتساپ"
        >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="#0077b5">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
            </svg>
        </a>
        
    </div>
    
    
    
</div>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #10b981;
    color: white;
    padding: 12px 20px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    opacity: 0;
    transform: translateY(-20px);
    transition: all 0.3s ease;
}

.notification.show {
    opacity: 1;
    transform: translateY(0);
}

.notification.fade-out {
    opacity: 0;
    transform: translateY(-20px);
}
</style>

<script>
function copyToClipboard(url) {
    navigator.clipboard.writeText(url).then(function() {
        showNotification('لینک کپی شد!');
    }).catch(function(err) {
        console.error('خطا در کپی کردن: ', err);
        showNotification('خطا در کپی کردن لینک');
    });
}

function showNotification(message) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create new notification
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.classList.add('fade-out');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>