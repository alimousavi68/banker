<?php
$post_id = get_the_ID();
$excerpt = get_the_excerpt();
$featured_image = get_the_post_thumbnail_url($post_id, 'large');
?>

<div class="bg-white pb-6 border-b border-border -lg overflow-hidden ">
    <div class="flex flex-col lg:flex-row">
        
        <!-- Content Section -->
        <div class="flex-1 p-6 lg:p-8">
            <!-- Post Title -->
            <h1 class="text-2xl lg:text-3xl font-bold text-black mb-4 leading-relaxed">
                <?php the_title(); ?>
            </h1>
            
            <!-- Post Excerpt -->
            <?php if ($excerpt): ?>
                <div class="text-grayText text-base lg:text-lg leading-relaxed mb-6">
                    <?php echo wp_trim_words($excerpt, 50, '...'); ?>
                </div>
            <?php endif; ?>
            
           
        </div>
        
        <!-- Featured Image Section -->
        <?php if ($featured_image): ?>
            <div class="lg:w-2/5 lg:max-w-md">
                <div class="relative h-64 lg:h-full">
                    <img 
                        src="<?php echo esc_url($featured_image); ?>" 
                        alt="<?php echo esc_attr(get_the_title()); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                    <!-- Overlay gradient for better text readability if needed -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent lg:hidden"></div>
                </div>
            </div>
        <?php endif; ?>
        
    </div>
</div>