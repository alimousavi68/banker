<?php
// Get car section settings from customizer
$car_settings = banker_get_car_section_settings();

// کوئری مجزا برای بخش خودرو (2 پست)
$car_query = new WP_Query(array(
    'cat' => $car_settings['car_category'],
    'posts_per_page' => $car_settings['car_posts_count'],
    'post_status' => 'publish'
));

$car_posts = array();
if ($car_query->have_posts()) {
    while ($car_query->have_posts()) {
        $car_query->the_post();
        $car_posts[] = array(
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'excerpt' => get_the_excerpt(),
            'category' => get_the_category()[0]->name ?? '',
            'date' => get_the_date(),
            'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
        );
    }
    wp_reset_postdata();
}

// کوئری مجزا برای بخش اقتصاد و بیمه (3 پست)
$economy_query = new WP_Query(array(
    'cat' => $car_settings['economy_category'],
    'posts_per_page' => $car_settings['economy_posts_count'],
    'offset' => 2,
    'post_status' => 'publish'
));

$economy_posts = array();
if ($economy_query->have_posts()) {
    while ($economy_query->have_posts()) {
        $economy_query->the_post();
        $economy_posts[] = array(
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'excerpt' => get_the_excerpt(),
            'category' => get_the_category()[0]->name ?? '',
            'date' => get_the_date(),
            'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
        );
    }
    wp_reset_postdata();
}
?>

<!--شروع بخش  خودرو-->
<?php if (!empty($car_posts)): ?>
<section class="flex flex-col md:flex-row  max-w-[1400px] mx-auto px-4  sm:px-4 lg:px-6 border-b border-border mt-8 pb-8 gap-4">
  <div class="w-full md:w-2/3 md:border-l md:ml-4 md:pl-4 border-border">
    <div class="flex  justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($car_settings['car_title']); ?>
      </h4>
      <div class="flex items-center gap-2">
        <a href="#" class="text-[12px] text-secondary font-medium">
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
    <!--شروع باکس های بخش بانکداری-->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

      <!-- Box 1 -->
      <?php if (isset($car_posts[0])): ?>
      <a href="<?php echo esc_url($car_posts[0]['link']); ?>" class="flex md:border-l md:ml-4 md:pl-4 border-border gap-6 flex-col group cursor-pointer md:p-2 transition duration-300 rounded no-underline">
        <!-- تصویر -->
        <div class="overflow-hidden">
          <img src="<?php echo esc_url($car_posts[0]['image'] ?: get_template_directory_uri() . '/assets/images/bankdariImg1.jpg'); ?>"
            class="h-[260px] w-full object-cover transition duration-500 group-hover:scale-105 group-hover:brightness-110"
            alt="<?php echo esc_attr($car_posts[0]['title']); ?>">
        </div>

        <!-- عنوان -->
        <h3 class="font-bold text-lg text-black transition-colors duration-300 group-hover:text-secondary">
          <?php echo esc_html($car_posts[0]['title']); ?>
        </h3>

      

        <!-- توضیح کوتاه -->
        <p class="text-grayText text-[14px] font-medium line-clamp-3">
          <?php echo esc_html($car_posts[0]['excerpt']); ?>
        </p>

          <!-- زمان -->
        <div class="flex justify-end gap-1 items-center">
          <span>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_51_1872)">
                <path d="M6 3V6L8 7M11 6C11 8.76142 8.76142 11 6 11C3.23858 11 1 8.76142 1 6C1 3.23858 3.23858 1 6 1C8.76142 1 11 3.23858 11 6Z"
                  stroke="#858585" stroke-linecap="round" stroke-linejoin="round" />
              </g>
              <defs>
                <clipPath id="clip0_51_1872">
                  <rect width="12" height="12" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </span>
          <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($car_posts[0]['time_diff']); ?></p>
        </div>

      </a>
      <?php endif; ?>

      <!-- Box 2 -->
      <?php if (isset($car_posts[1])): ?>
      <a href="<?php echo esc_url($car_posts[1]['link']); ?>" class="flex  gap-6 flex-col group cursor-pointer md:p-2 transition duration-300 rounded no-underline">
        <!-- تصویر -->
        <div class="overflow-hidden">
          <img src="<?php echo esc_url($car_posts[1]['image'] ?: get_template_directory_uri() . '/assets/images/bankdariImg2.jpg'); ?>"
            class="h-[260px] w-full object-cover transition duration-500 group-hover:scale-105 group-hover:brightness-110"
            alt="<?php echo esc_attr($car_posts[1]['title']); ?>">
        </div>

        <!-- عنوان -->
        <h3 class="font-bold text-lg text-black transition-colors duration-300 group-hover:text-secondary">
          <?php echo esc_html($car_posts[1]['title']); ?>
        </h3>

       

        <!-- توضیح کوتاه -->
        <p class="text-grayText text-[14px] font-medium line-clamp-3">
          <?php echo esc_html($car_posts[1]['excerpt']); ?>
        </p>

         <!-- زمان -->
        <div class="flex justify-end gap-1 items-center">
          <span>
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_51_1872)">
                <path d="M6 3V6L8 7M11 6C11 8.76142 8.76142 11 6 11C3.23858 11 1 8.76142 1 6C1 3.23858 3.23858 1 6 1C8.76142 1 11 3.23858 11 6Z"
                  stroke="#858585" stroke-linecap="round" stroke-linejoin="round" />
              </g>
              <defs>
                <clipPath id="clip0_51_1872">
                  <rect width="12" height="12" fill="white" />
                </clipPath>
              </defs>
            </svg>
          </span>
          <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($car_posts[1]['time_diff']); ?></p>
        </div>
        
      </a>
      <?php endif; ?>


    </div>
    <!--پایان بخش باکس های بانکداری-->

    <!--پایان باکس های بخش بانکداری-->
  </div>
  <!---------------------------------->
  <?php if (!empty($economy_posts)): ?>
  <div class="w-full md:w-1/3">
    <div class="flex justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($car_settings['economy_title']); ?>
      </h4>
      <div class="flex items-center gap-2">
        <a href="#" class="text-[12px] text-secondary font-medium">
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

    <?php if (isset($economy_posts[0])): ?>
    <a href="<?php echo esc_url($economy_posts[0]['link']); ?>" style="margin-top: 24px !important;" class="relative flex flex-col  justify-end w-full h-[239px] bg-cover bg-center overflow-hidden group">

      <!-- تصویر با افکت زوم -->
      <div class="absolute inset-0  bg-cover bg-center 
              transition-transform duration-500 ease-in-out group-hover:scale-110" style="background-image: url('<?php echo esc_url($economy_posts[0]['image'] ?: get_template_directory_uri() . '/assets/images/shobe.jpg'); ?>');"></div>
      <div class="absolute mt-4 inset-0 bg-gradient-to-t from-primary via-transparent to-transparent z-0"></div>

      <!-- متن -->
      <div class="relative z-10 w-full pb-3 px-3 flex flex-col gap-2 md:gap-4 text-white">
        <p class="bg-white w-fit text-secondary text-[10px] py-1 px-2">
          <?php echo esc_html($economy_posts[0]['category']); ?>
        </p>
        <h4 class="text-lightBg font-semibold text-[22px] sm:text-[18px] md:text-[22px] leading-snug">
          <?php echo esc_html($economy_posts[0]['title']); ?>
        </h4>
      </div>

    </a>
    <?php endif; ?>
    <div class="w-full mt-4 m-auto bg-border h-[1px]">
    </div>
    <?php if (isset($economy_posts[1])): ?>
    <a href="<?php echo esc_url($economy_posts[1]['link']); ?>" class="flex gap-4 py-4 border-b group border-border items-center cursor-pointer transition duration-300 no-underline">
      <!-- تصویر -->
      <div class="overflow-hidden">
        <img src="<?php echo esc_url($economy_posts[1]['image'] ?: get_template_directory_uri() . '/assets/images/bekrSection3.jpg'); ?>"
          class="object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-80 h-[100px] w-[148px]"
          alt="<?php echo esc_attr($economy_posts[1]['title']); ?>">
      </div>

      <!-- متن -->
      <div class="flex flex-col gap-3">
        <p class="bg-lightBg text-secondary text-[10px] py-[2px] px-2 w-fit">
          <?php echo esc_html($economy_posts[1]['category']); ?>
        </p>
        <h6 class="font-semibold text-black text-[14px] transition-colors duration-300 group-hover:text-secondary">
          <?php echo esc_html($economy_posts[1]['title']); ?>
        </h6>
      </div>
    </a>
    <?php endif; ?>
    
    <?php if (isset($economy_posts[2])): ?>
    <a href="<?php echo esc_url($economy_posts[2]['link']); ?>" class="flex gap-4 py-4 group  items-center cursor-pointer transition duration-300 no-underline">
      <!-- تصویر -->
      <div class="overflow-hidden">
        <img src="<?php echo esc_url($economy_posts[2]['image'] ?: get_template_directory_uri() . '/assets/images/bekrSection3.jpg'); ?>"
          class="object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-80 h-[100px] w-[148px]"
          alt="<?php echo esc_attr($economy_posts[2]['title']); ?>">
      </div>

      <!-- متن -->
      <div class="flex flex-col gap-3">
        <p class="bg-lightBg text-secondary text-[10px] py-[2px] px-2 w-fit">
          <?php echo esc_html($economy_posts[2]['category']); ?>
        </p>
        <h6 class="font-semibold text-black text-[14px] transition-colors duration-300 group-hover:text-secondary">
          <?php echo esc_html($economy_posts[2]['title']); ?>
        </h6>
      </div>
    </a>
    <?php endif; ?>

  </div>
  <?php endif; ?>
</section>
<?php endif; ?>
<!--پایان بخش  خودرو-->