<?php
// Get post information
$post_id = get_the_ID();
$category = get_the_category($post_id);
$primary_category = !empty($category) ? $category[0] : null;
$post_date = get_the_date('Y/m/d');
$post_time = get_the_date('H:i');
$short_url = home_url('?p=' . $post_id); // Short URL with post ID

// Get main category from meta box
$main_category_id = get_post_meta($post_id, '_banker_main_category', true);
$main_category = null;
if ($main_category_id) {
    $main_category = get_category($main_category_id);
}

$excerpt = get_the_excerpt();
$featured_image = get_the_post_thumbnail_url($post_id, 'large');

?>


<div class=" border-b border-border pb-4">
    
    <!-- Post Meta Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 pb-4 border-b border-gray-200">
        <!-- Right Side: Breadcrumb -->
        <div class="order-2 md:order-1 mb-3 md:mb-0">
            <nav class="text-sm text-grayText">
                <a href="<?php echo home_url(); ?>" class="hover:text-secondary transition-colors">خانه</a>
                <?php 
                // Check if main category is set in meta box
                if ($main_category && !is_wp_error($main_category)): ?>
                    <span class="mx-2">/</span>
                    <a href="<?php echo get_category_link($main_category->term_id); ?>" class="hover:text-secondary transition-colors">
                        <?php echo esc_html($main_category->name); ?>
                    </a>
                <?php elseif ($primary_category): ?>
                    <span class="mx-2">/</span>
                    <a href="<?php echo get_category_link($primary_category->term_id); ?>" class="hover:text-secondary transition-colors">
                        <?php echo esc_html($primary_category->name); ?>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
        
        <!-- Left Side: Date, Print, Share -->
        <div class="order-1 md:order-2 flex items-center gap-4">
            <!-- Publication Date -->
            <div class="flex items-center gap-2 text-sm text-grayText">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 2V5M16 2V5M3.5 9.09H20.5M21 8.5V17C21 20 19.5 22 16 22H8C4.5 22 3 20 3 17V8.5C3 5.5 4.5 3.5 8 3.5H16C19.5 3.5 21 5.5 21 8.5Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span><?php echo $post_date; ?></span>
            </div>
            
            <!-- Print Button -->
            <button onclick="window.print()" class="p-2 text-grayText hover:text-secondary hover:bg-gray-100 transition-all duration-200 rounded-full" title="پرینت">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6 9V2H18V9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 18H4C3.46957 18 2.96086 17.7893 2.58579 17.4142C2.21071 17.0391 2 16.5304 2 16V11C2 10.4696 2.21071 9.96086 2.58579 9.58579C2.96086 9.21071 3.46957 9 4 9H20C20.5304 9 21.0391 9.21071 21.4142 9.58579C21.7893 9.96086 22 10.4696 22 11V16C22 16.5304 21.7893 17.0391 21.4142 17.4142C21.0391 17.7893 20.5304 18 20 18H18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18 14H6V22H18V14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            
            <!-- Share Button -->
            <button onclick="copyToClipboard('<?php echo esc_js($short_url); ?>')" class="p-2 text-grayText hover:text-secondary hover:bg-gray-100 transition-all duration-200 rounded-full" title="اشتراک‌گذاری">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 8C19.6569 8 21 6.65685 21 5C21 3.34315 19.6569 2 18 2C16.3431 2 15 3.34315 15 5C15 6.65685 16.3431 8 18 8Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 15C7.65685 15 9 13.6569 9 12C9 10.3431 7.65685 9 6 9C4.34315 9 3 10.3431 3 12C3 13.6569 4.34315 15 6 15Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18 22C19.6569 22 21 20.6569 21 19C21 17.3431 19.6569 16 18 16C16.3431 16 15 17.3431 15 19C15 20.6569 16.3431 22 18 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M8.59 13.51L15.42 17.49" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M15.41 6.51L8.59 10.49" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
    </div>
    
    <!-- Post Intro Section -->
    <div class="mb-6">
        <h1 class="text-2xl md:text-[25px] lg:text-[27px] font-bold line-clamp-4 text-black leading-relaxed mb-4">
            <?php the_title(); ?>
        </h1>
        <div class="flex flex-col lg:flex-row gap-6">
            

            <!-- left Column: Content -->
            <div class="lg:w-1/2 flex flex-col lg:flex-col gap-4 ">
                <!-- Title: full width -->
                <div class="w-full flex flex-col lg:flex-row gap-4 justify-between">
                </div>

                <!-- Post Excerpt: full width -->
                <?php if (has_excerpt()): ?>
                    <div class="w-full text-grayText line-clamp-2 leading-relaxed">
                        <?php the_excerpt(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- right Column: Featured Image -->
            <div class="lg:w-1/2">
                <?php if (has_post_thumbnail()): ?>
                    <div class=" overflow-hidden shadow-md max-h-[265px]">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto object-cover')); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>


</div>

<style>
    .corner-tr::after {
        content: '';
        position: absolute;
        top: -1px;
        right: -1px;
        width: 15px;
        height: 15px;
        background-color: white;
        clip-path: polygon(0 0, 100% 0, 100% 100%);
    }
    
    /* Notification styles */
    .share-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 9999;
        opacity: 0;
        transform: translateX(100%);
        transition: all 0.3s ease-in-out;
    }
    
    .share-notification.show {
        opacity: 1;
        transform: translateX(0);
    }
</style>

<script>
function copyToClipboard(url) {
    // Create a temporary textarea element
    const textarea = document.createElement('textarea');
    textarea.value = url;
    document.body.appendChild(textarea);
    
    // Select and copy the text
    textarea.select();
    textarea.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        showNotification('لینک با موفقیت کپی شد!');
    } catch (err) {
        // Fallback for modern browsers
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(() => {
                showNotification('لینک با موفقیت کپی شد!');
            }).catch(() => {
                showNotification('خطا در کپی کردن لینک');
            });
        } else {
            showNotification('خطا در کپی کردن لینک');
        }
    }
    
    // Remove the temporary element
    document.body.removeChild(textarea);
}

function showNotification(message) {
    // Remove existing notification if any
    const existingNotification = document.querySelector('.share-notification');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'share-notification';
    notification.textContent = message;
    
    // Add to body
    document.body.appendChild(notification);
    
    // Show notification
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    // Hide and remove notification after 3 seconds
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}
</script>