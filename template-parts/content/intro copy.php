<?php
// Get post information
$post_id = get_the_ID();
$category = get_the_category($post_id);
$primary_category = !empty($category) ? $category[0] : null;
$post_date = get_the_date('Y/m/d');
$post_time = get_the_date('H:i');

$excerpt = get_the_excerpt();
$featured_image = get_the_post_thumbnail_url($post_id, 'large');

?>


<div class=" border-b border-border pb-4">

    <!-- Post Intro Section -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Left Column: Featured Image -->
            <div class="lg:w-1/2">
                <?php if (has_post_thumbnail()): ?>
                    <div class=" overflow-hidden shadow-md max-h-[265px]">
                        <?php the_post_thumbnail('large', array('class' => 'w-full h-auto object-cover')); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Content -->
            <div class="lg:w-1/2 flex flex-col lg:flex-col gap-4 ">
                <!-- Title: full width -->
                <div class="w-full flex flex-col lg:flex-row gap-4 justify-between">
                    <h1 class="text-2xl md:text-[25px] lg:text-[27px] font-bold line-clamp-4 text-black leading-relaxed mb-4">
                        <?php the_title(); ?>
                    </h1>


                    <!-- Meta Info: full width -->

                    <div class="bg-neutral-200 text-white p-4 relative corner-tr max-w-[140px] max-h-[160px]">
                        <!-- Category with Quote Icon -->
                        <div class="flex items-center gap-0 mb-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-secondary flex-shrink-0">
                                <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h4v10h-10z" fill="currentColor" />
                            </svg>
                            <?php if ($primary_category): ?>
                                <span class="text-gray-600 px-2 py-1 text-md font-medium whitespace-nowrap inline-block w-full truncate">
                                    <?php echo esc_html($primary_category->name); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Separator -->
                        <div class="border-t border-gray-300 mb-3"></div>

                        <!-- Date and Time -->
                        <div class="flex items-center gap-2 mb-3 text-grayText text-sm ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h6"></path>
                                <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"></path>
                            </svg>
                            <span>
                                <?php
                                // Use WordPress built-in localization instead of manual mapping
                                $day   = get_the_date('j');
                                $month = get_the_date('m');
                                // Let WordPress handle Persian month names via locale
                                // $month_name = date_i18n('F', strtotime(get_the_date('Y-m-d')));
                                ?>
                                    <span class="text-xs font-medium text-gray-500">
                                        <?php echo get_the_date(''); ?>
                                    </span>



                        </div>

                        <!-- Action Icons -->
                        <div class="flex items-center justify-center gap-3">
                            <!-- Share Icon -->
                            <button class="p-2 hover:bg-white transition-colors group" title="اشتراک‌گذاری">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText group-hover:text-secondary">
                                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M18 22a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM6 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM18 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6ZM8.7 13.3l6.6 3.4M15.3 5.7l-6.6 3.4" />
                                </svg>
                            </button>

                            <!-- Print Icon -->
                            <button class="p-2 hover:bg-white d transition-colors group" title="چاپ" onclick="window.print()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText group-hover:text-secondary">
                                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17.5 16H22V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10h4.5" />
                                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6.5 20h11V8h-11v12Z" />
                                </svg>
                            </button>

                            <!-- Comment Icon -->
                            <a href="#comments" class="p-2 hover:bg-white transition-colors group" title="نظرات">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor" class="text-grayText group-hover:text-secondary">
                                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12c0 1.821.487 3.53 1.338 5L2.5 21.5l4.5-.838A9.955 9.955 0 0 0 12 22Z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Post Excerpt: full width -->
                <?php if (has_excerpt()): ?>
                    <div class="w-full text-grayText line-clamp-2 leading-relaxed">
                        <?php the_excerpt(); ?>
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
</style>