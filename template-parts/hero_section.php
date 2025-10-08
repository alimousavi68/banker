<?php
// Query for featured posts
    $featured_query = new WP_Query(array(
        'cat' => 8, // Change this to your desired category ID (integer) or use 'category_name' for slug
        'posts_per_page' => 5,
    ));

// Prepare posts array
$posts_array = array();

if ($featured_query->have_posts()) {
    while ($featured_query->have_posts()) {
        $featured_query->the_post();
        $posts_array[] = array(
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/images/default-image.jpg',
            'category' => get_the_category_list(', ')
        );
    }
    wp_reset_postdata();
}
?>

<?php if (!empty($posts_array) && count($posts_array) > 0): ?>
<!--START HERO SECTION-->
    <section class="h-fit max-w-[1400px] mx-auto px-4 border-b border-border pb-8 mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- تصویر بزرگ -->
      <div class="relative flex flex-col justify-end w-full h-[300px] sm:h-[300px] md:h-full 
    overflow-hidden group">

        <!-- تصویر با افکت زوم -->
        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
          style="background-image: url('<?php echo esc_url($posts_array[0]['image']); ?>');"></div>
        <!-- گرادیانت -->
        <div class="absolute inset-0 bg-gradient-to-t from-primary via-transparent to-transparent z-10"></div>

        <!-- متن -->
        <div class="relative z-20 w-full pb-3 px-3 flex flex-col gap-2 md:gap-4 transition-colors duration-300">
          <p class="bg-white w-fit text-secondary text-[10px] py-1 px-2   transition-colors duration-300">
            <!-- <?php //echo esc_html($posts_array[0]['category']); ?> -->
          </p>
          <a href="<?php echo esc_url($posts_array[0]['link']); ?>" class="text-lightBg font-semibold text-[22px] sm:text-[18px] md:text-[22px] leading-snug 
        group-hover:text-secondary transition-colors duration-300">
            <?php echo esc_html($posts_array[0]['title']); ?>
          </a>
        </div>

      </div>



      <!-- boxes -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-4  md:border-r md:pr-4 border-border">
        <!--گرید دو باکس اول-->
        <div class="grid grid-cols-1 px-2 gap-4 md:border-l md:pl-4 border-border">
          <?php if (!empty($posts_array[1])): ?>
          <a href="<?php echo esc_url($posts_array[1]['link']); ?>" class="flex flex-col group border-b md:border-b border-border gap-2 md:gap-4 pb-4">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($posts_array[1]['image']); ?>" alt="<?php echo esc_attr($posts_array[1]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-80">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[10px] h-[10px] bg-secondary mt-2 rounded-full  inline-block"></span>
              <span class="text-md  transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium">
                <?php echo esc_html($posts_array[1]['title']); ?>
              </span>
            </p>
          </a>
          <?php endif; ?>

          <?php if (!empty($posts_array[2])): ?>
          <a href="<?php echo esc_url($posts_array[2]['link']); ?>" class="flex flex-col pb-4 border-b group md:border-none border-border  gap-2 md:gap-4 ">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($posts_array[2]['image']); ?>" alt="<?php echo esc_attr($posts_array[2]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110 hover:opacity-80">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[10px] h-[10px] bg-secondary mt-2 rounded-full inline-block"></span>
              <span class="text-md  transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium">
                <?php echo esc_html($posts_array[2]['title']); ?>
              </span>
            </p>
          </a>
          <?php endif; ?>
        </div>
        <!--پایان گرید دو باکس اول-->
        <!--گرید دو باکس دوم-->
        <div class="grid grid-cols-1 px-2 gap-4 ">
          <?php if (!empty($posts_array[3])): ?>
          <a href="<?php echo esc_url($posts_array[3]['link']); ?>" class="flex flex-col border-b group md:border-b border-border gap-2 md:gap-4 pb-4">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($posts_array[3]['image']); ?>" alt="<?php echo esc_attr($posts_array[3]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110 hover:opacity-80">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[10px] h-[10px] bg-secondary mt-2 rounded-full inline-block"></span>
              <span class="text-md  transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium">
                <?php echo esc_html($posts_array[3]['title']); ?>
              </span>
            </p>
          </a>
          <?php endif; ?>

          <?php if (!empty($posts_array[4])): ?>
          <a href="<?php echo esc_url($posts_array[4]['link']); ?>" class="flex flex-col group pb-4 border-b md:border-none border-border  gap-2 md:gap-4 ">
            <div class="heroImage overflow-hidden " style="height: 140px !important;">
              <img src="<?php echo esc_url($posts_array[4]['image']); ?>" alt="<?php echo esc_attr($posts_array[4]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out hover:scale-110 hover:opacity-80">
            </div>
            <p class="flex items-start gap-2 pr-2">
              <span class="w-[10px] h-[10px] bg-secondary mt-2 rounded-full inline-block"></span>
              <span class="text-md  transition-color duration-300 ease-in-out group-hover:text-secondary  font-medium">
                <?php echo esc_html($posts_array[4]['title']); ?>
              </span>
            </p>
          </a>
          <?php endif; ?>
        </div>
        <!--پایان گرید دو باکس دوم-->
      </div>
    </section>
<?php endif; ?>