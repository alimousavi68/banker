<?php
/**
 * Default Sidebar Content
 * This will be displayed when no widgets are added to the sidebar
 */
?>

<!-- Search Widget -->
<div class="widget mb-6 bg-white border border-border rounded-lg p-4">
    <h3 class="widget-title text-lg font-bold text-black mb-4 pb-2 border-b border-border flex items-center gap-2">
        <div class="w-1 h-5 bg-secondary rounded"></div>
        جستجو
    </h3>
    <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="search-form">
        <div class="relative">
            <input 
                type="search" 
                name="s" 
                placeholder="جستجو در سایت..." 
                value="<?php echo get_search_query(); ?>"
                class="w-full px-4 py-2 pr-10 border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:border-transparent"
            >
            <button 
                type="submit" 
                class="absolute left-2 top-1/2 transform -translate-y-1/2 text-grayText hover:text-secondary"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17 17l4 4M3 11a8 8 0 1 0 16 0 8 8 0 0 0-16 0Z"></path>
                </svg>
            </button>
        </div>
    </form>
</div>

<!-- Recent Posts Widget -->
<div class="widget mb-6 bg-white border border-border rounded-lg p-4">
    <h3 class="widget-title text-lg font-bold text-black mb-4 pb-2 border-b border-border flex items-center gap-2">
        <div class="w-1 h-5 bg-secondary rounded"></div>
        آخرین مطالب
    </h3>
    <?php
    $recent_posts = wp_get_recent_posts(array(
        'numberposts' => 5,
        'post_status' => 'publish'
    ));
    
    if ($recent_posts) :
    ?>
        <ul class="space-y-3">
            <?php foreach ($recent_posts as $post) : ?>
                <li class="group">
                    <a href="<?php echo get_permalink($post['ID']); ?>" class="flex gap-3 items-start">
                        <?php if (has_post_thumbnail($post['ID'])) : ?>
                            <div class="flex-shrink-0 w-16 h-16 rounded overflow-hidden">
                                <?php echo get_the_post_thumbnail($post['ID'], 'thumbnail', array(
                                    'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-200'
                                )); ?>
                            </div>
                        <?php endif; ?>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-black group-hover:text-secondary transition-colors line-clamp-2 mb-1">
                                <?php echo wp_trim_words($post['post_title'], 8, '...'); ?>
                            </h4>
                            <span class="text-xs text-grayText">
                                <?php echo get_the_date('Y/m/d', $post['ID']); ?>
                            </span>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<!-- Categories Widget -->
<div class="widget mb-6 bg-white border border-border rounded-lg p-4">
    <h3 class="widget-title text-lg font-bold text-black mb-4 pb-2 border-b border-border flex items-center gap-2">
        <div class="w-1 h-5 bg-secondary rounded"></div>
        دسته‌بندی‌ها
    </h3>
    <?php
    $categories = get_categories(array(
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 8,
        'hide_empty' => true
    ));
    
    if ($categories) :
    ?>
        <ul class="space-y-2">
            <?php foreach ($categories as $category) : ?>
                <li>
                    <a 
                        href="<?php echo get_category_link($category->term_id); ?>" 
                        class="flex items-center justify-between py-2 px-3 rounded hover:bg-lightBg transition-colors group"
                    >
                        <span class="text-sm text-black group-hover:text-secondary">
                            <?php echo esc_html($category->name); ?>
                        </span>
                        <span class="text-xs bg-secondary text-white px-2 py-1 rounded-full">
                            <?php echo $category->count; ?>
                        </span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<!-- Tags Widget -->
<div class="widget mb-6 bg-white border border-border rounded-lg p-4">
    <h3 class="widget-title text-lg font-bold text-black mb-4 pb-2 border-b border-border flex items-center gap-2">
        <div class="w-1 h-5 bg-secondary rounded"></div>
        برچسب‌های محبوب
    </h3>
    <?php
    $tags = get_tags(array(
        'orderby' => 'count',
        'order'   => 'DESC',
        'number'  => 15,
        'hide_empty' => true
    ));
    
    if ($tags) :
    ?>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($tags as $tag) : ?>
                <a 
                    href="<?php echo get_tag_link($tag->term_id); ?>" 
                    class="inline-block px-3 py-1 text-xs bg-lightBg border border-border rounded-full text-grayText hover:bg-secondary hover:text-white hover:border-secondary transition-all"
                >
                    #<?php echo esc_html($tag->name); ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Newsletter Widget -->
<div class="widget mb-6 bg-gradient-to-br from-secondary to-blue-600 text-white rounded-lg p-4">
    <h3 class="widget-title text-lg font-bold mb-4 pb-2 border-b border-white/20 flex items-center gap-2">
        <div class="w-1 h-5 bg-white rounded"></div>
        خبرنامه
    </h3>
    <p class="text-sm mb-4 text-white/90">
        برای دریافت آخرین اخبار و مطالب، در خبرنامه ما عضو شوید.
    </p>
    <form class="space-y-3">
        <input 
            type="email" 
            placeholder="ایمیل شما..." 
            class="w-full px-3 py-2 rounded text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white"
        >
        <button 
            type="submit" 
            class="w-full bg-white text-secondary py-2 rounded font-medium hover:bg-gray-100 transition-colors"
        >
            عضویت در خبرنامه
        </button>
    </form>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>