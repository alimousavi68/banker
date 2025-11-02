<?php
// Get hero section settings from customizer
$hero_settings = banker_get_hero_section_settings();

// Query for the main featured post (large image)
$main_post_query = new WP_Query(array(
  'cat' => $hero_settings['category'],
  'posts_per_page' => 1,
  'post_status' => 'publish'
));

// Query for the 4 smaller featured posts
$small_posts_query = new WP_Query(array(
  'cat' => $hero_settings['category'],
  'posts_per_page' => 4,
  'offset' => 1, // Exclude the main post
  'post_status' => 'publish'
));

?>

<?php if ($main_post_query->have_posts() || $small_posts_query->have_posts()): ?>
  <!--START HERO SECTION-->
  <section class="h-fit max-w-[1400px] mx-auto px-4 border-b border-border pb-8 mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- boxes - در موبایل اول نمایش داده می‌شود -->
    <div class="order-2 md:order-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4 md:border-r md:pr-4 border-border">
      <!--گرید دو باکس اول-->
      <div class="grid grid-cols-1 px-2 gap-4 md:border-l md:pl-4 border-border">
        <?php
        $count = 0;
        while ($small_posts_query->have_posts() && $count < 2) : $small_posts_query->the_post();
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_411x231') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
        ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="flex flex-col group border-b md:border-b border-border gap-2 md:gap-4 pb-4">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover transition-transform duration-1000 ease-in-out group-hover:scale-105 group-hover:opacity-80 will-change-transform">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[7px] h-[10px] bg-secondary mt-2 rounded-full  inline-block"></span>
              <span class="text-md w-11/12  transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium line-clamp-2 min-h-[48px]">
                <?php echo esc_html(get_the_title()); ?>
              </span>
            </p>
          </a>
        <?php
          $count++;
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
      <!--پایان گرید دو باکس اول-->
      <!--گرید دو باکس دوم-->
      <div class="grid grid-cols-1 px-2 gap-4 ">
        <?php
        $count = 0;
        // Reset the small posts query to get the next two posts
        $small_posts_query->rewind_posts();
        // Skip the first two posts already displayed
        for ($i = 0; $i < 2; $i++) {
            $small_posts_query->the_post();
        }
        while ($small_posts_query->have_posts() && $count < 2) : $small_posts_query->the_post();
          $image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_411x231') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
        ?>
          <a href="<?php echo esc_url(get_permalink()); ?>" class="flex flex-col border-b group md:border-b border-border gap-2 md:gap-4 pb-4">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110 hover:opacity-80">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[7px] h-[10px] bg-secondary mt-2 rounded-full inline-block"></span>
              <span class="text-md w-11/12 transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium line-clamp-2 min-h-[48px]">
                <?php echo esc_html(get_the_title()); ?>
              </span>
            </p>
          </a>
        <?php
          $count++;
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
      <!--پایان گرید دو باکس دوم-->
    </div>

    <!-- تصویر بزرگ - در موبایل دوم نمایش داده می‌شود -->
    <div class="order-1 md:order-1 relative flex flex-col justify-end w-full h-[300px] md:h-[450px] overflow-hidden group">
      <?php if ($main_post_query->have_posts()) : $main_post_query->the_post();
        $main_image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_672x378') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
      ?>
        <a href="<?php echo esc_url(get_permalink()); ?>">
          <!-- تصویر با افکت زوم -->
          <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 ease-in-out group-hover:scale-105">
            <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover">
          </div>
          <!-- گرادیانت -->
          <div class="absolute inset-0 bg-gradient-to-t from-primary via-transparent to-transparent z-10"></div>

          <!-- متن -->
          <div class="relative z-20 w-full pb-3 px-3 flex flex-col gap-2 md:gap-4 transition-colors duration-500">
            
            <a href="<?php echo esc_url(get_permalink()); ?>" class="text-white pb-3 font-semibold text-[18px] md:text-[22px] leading-snug 
          group-hover:text-secondary transition-colors duration-500">
              <?php echo esc_html(get_the_title()); ?>
            </a>
          </div>
        </a>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
    </div>
  </section>
<?php endif; ?>