<?php
// Get page information
$page_id = get_the_ID();
$page_title = get_the_title();
$featured_image = get_the_post_thumbnail_url($page_id, 'large');
?>

<div class="border-b border-border pb-6">
    
    <!-- Page Header Section -->
    <div class="mb-6">
        
        <?php if (has_post_thumbnail()): ?>
        <!-- Layout with Featured Image -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Featured Image -->
            <div class="lg:w-1/2">
                <div class="overflow-hidden shadow-md max-h-[300px] rounded-lg">
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-auto object-cover')); ?>
                </div>
            </div>

            <!-- Right Column: Content -->
            <div class="lg:w-1/2 flex flex-col justify-center">
                
                <!-- Page Title -->
                <div>
                    <h1 class="text-2xl lg:text-3xl font-bold text-black leading-tight">
                        <?php echo esc_html($page_title); ?>
                    </h1>
                </div>
                
            </div>
        </div>
        
        <?php else: ?>
        <!-- Layout without Featured Image -->
        <div class="text-center py-8">
            
            <!-- Page Title -->
            <h1 class="text-3xl lg:text-4xl font-bold text-black leading-tight">
                <?php echo esc_html($page_title); ?>
            </h1>
            
        </div>
        <?php endif; ?>
        
    </div>
    
</div>