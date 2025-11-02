<?php
// Get banking section settings from customizer
$banking_settings = banker_get_banking_section_settings();

// Query for the main banking post
$main_banking_query = new WP_Query(array(
  'cat' => $banking_settings['category'], // Banking category ID
  'posts_per_page' => 1,
  'post_status' => 'publish'
));

// Query for the 4 smaller banking posts
$small_banking_query = new WP_Query(array(
  'cat' => $banking_settings['category'], // Banking category ID
  'posts_per_page' => 4,
  'offset' => 1, // Exclude the main post
  'post_status' => 'publish'
));

?>

<?php if ($main_banking_query->have_posts() || $small_banking_query->have_posts()): ?>
  <!--شروع بخش بانکداری-->
  <section class="mt-8 max-w-[1400px] mx-auto px-4 sm:px-4 lg:px-6 ">
    <div class="flex  justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($banking_settings['title']); ?>
      </h4>
      <div class="flex items-center gap-2">
        <a href="<?php echo esc_url(get_category_link($banking_settings['category'])); ?>" class="text-[12px] text-secondary  font-medium">
          مشاهده بیشتر
        </a>
        <span>
          <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9 9L1 1M1 1V6.33333M1 1H6.33333" stroke="#CD3737" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
        </span>
      </div>
    </div>
    <div class="space-y-[2px] mt-2">
      <div class="border-t-2  border-dotted border-border"></div>
      <div class="border-t-2  border-dotted border-border"></div>
      <div class="border-t-2  border-dotted border-border"></div>
    </div>
    <!--right section-->
    <div class="flex flex-col md:flex-row border-b border-border pb-8 pt-5 ">
      <?php if ($main_banking_query->have_posts()): $main_banking_query->the_post();
        $main_image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_672x378') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
      ?>
        <a href="<?php echo esc_url(get_permalink()); ?>" class="w-full md:w-1/2  flex-col gap-6 group block cursor-pointer">
          <!-- عکس -->
          <div class="h-[360px] mt-4 overflow-hidden">
            <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
          </div>

          <!-- متن -->
          <p class="transition-colors duration-300 text-[22px] mt-4 group-hover:text-secondary">
            <?php echo esc_html(get_the_title()); ?>
          </p>

          <!-- توضیح -->
          <p class="text-justify text-grayText text-[14px] transition-colors duration-300 line-clamp-3">
            <?php echo esc_html(get_the_excerpt()); ?>
          </p>

          <!-- زمان -->
          <div class="flex items-center justify-end gap-1">
            <span>
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_51_1872)">
                  <path d="M6 3V6L8 7M11 6C11 8.76142 8.76142 11 6 11C3.23858 11 1 8.76142 1 6C1 3.23858 3.23858 1 6 1C8.76142 1 11 3.23858 11 6Z" stroke="#858585" stroke-linecap="round" stroke-linejoin="round" />
                </g>
                <defs>
                  <clipPath id="clip0_51_1872">
                    <rect width="12" height="12" fill="white" />
                  </clipPath>
                </defs>
              </svg>
            </span>
            <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html(human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'); ?></p>
          </div>
        </a>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>

      <!--left section-->
      <div class="w-full md:w-1/2 md:border-r border-border md:mr-4 md:pr-4 flex flex-col">

        <?php while ($small_banking_query->have_posts()): $small_banking_query->the_post();
          $small_image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_411x231') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
        ?>
          <!-- آیتم -->
          <a href="<?php echo esc_url(get_permalink()); ?>" class="flex gap-4 py-4 border-b border-border items-start md:items-center group cursor-pointer transition-colors duration-300 ">
            <!-- عکس -->
            <div class="w-1/3 md:w-1/4 overflow-hidden">
              <img src="<?php echo esc_url($small_image_url); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?php echo esc_attr(get_the_title()); ?>">
            </div>

            <!-- متن -->
            <div class="flex w-3/4 md:w-3/4 flex-col gap-3">
              <p class="font-semibold text-black text-[16px] transition-colors duration-300 group-hover:text-secondary">
                <?php echo esc_html(get_the_title()); ?>
              </p>
              <p class="text-[14px]  line-clamp-2 text-justify text-grayText">
                <?php echo esc_html(get_the_excerpt()); ?>
              </p>
            </div>
          </a>
        <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>

      </div>

    </div>
  </section>
  <!--پایان بخش بانکداری-->
<?php endif; ?>