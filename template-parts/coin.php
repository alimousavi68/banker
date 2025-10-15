
<?php
// Get crypto section settings from customizer
$crypto_settings = banker_get_crypto_section_settings();

// کوئری برای دریافت پست‌های ارز دیجیتال
$crypto_query = new WP_Query(array(
    'cat' => $crypto_settings['category'],
    'posts_per_page' => $crypto_settings['posts_count'],
    'post_status' => 'publish',
    'meta_query' => array(
        array(
            'key' => '_thumbnail_id',
            'compare' => 'EXISTS'
        )
    )
));

// آماده‌سازی داده‌ها برای نمایش
$crypto_posts = array();
if ($crypto_query->have_posts()) {
    while ($crypto_query->have_posts()) {
        $crypto_query->the_post();
        $crypto_posts[] = array(
            'title' => get_the_title(),
            'link' => get_permalink(),
            'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
            'excerpt' => get_the_excerpt(),
            'category' => get_the_category()[0]->name,
            'date' => get_the_date(),
            'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
        );
    }
    wp_reset_postdata();
}
?>

<?php if (!empty($crypto_posts)): ?>
<!--شروع بخش ارز دیجیتال و طلا و ارز-->
<section class="mt-8 flex flex-col md:flex-row max-w-[1400px] mx-auto px-4  sm:px-4 lg:px-6">
  <div class="w-full md:border-l border-border md:ml-4 md:pl-4 md:w-2/3">
    <div class="flex justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($crypto_settings['title']); ?>
      </h4>
      <div class="flex items-center gap-2">
        <a href="#" class="text-[12px] text-secondary  font-medium">
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

    <div class="grid grid-cols-1 gap-4 pt-4">

      <!-- دو باکس اول -->
      <div class="grid gird-cols-1 md:grid-cols-2 gap-4 border-b border-border pb-5">

        <!-- آیتم ۱ -->
        <?php if (isset($crypto_posts[0])): ?>
        <a href="<?php echo esc_url($crypto_posts[0]['link']); ?>" class="flex border-b md:border-0 md:pb-0 pb-4 md:border-l border-border md:pl-4 flex-col gap-4 group cursor-pointer transition-colors duration-300 ">
          <!-- عکس -->
          <div class="h-[260px] overflow-hidden">
            <div class="h-full bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
              style="background-image: url('<?php echo esc_url($crypto_posts[0]['image']); ?>');"></div>
          </div>

          <!-- متن -->
          <p class="text-justify font-bold transition-colors duration-300 group-hover:text-secondary">
            <?php echo esc_html($crypto_posts[0]['title']); ?>
          </p>

          <!-- زمان -->
          <div class="flex justify-end gap-1 items-center">
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
            <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($crypto_posts[0]['time_diff']); ?></p>
          </div>
        </a>
        <?php endif; ?>


        <!-- آیتم ۲ -->
        <?php if (isset($crypto_posts[1])): ?>
        <a href="<?php echo esc_url($crypto_posts[1]['link']); ?>" class="flex flex-col gap-4 group cursor-pointer transition-colors duration-300 ">
          <!-- عکس -->
          <div class="h-[260px] overflow-hidden">
            <div class="h-full bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
              style="background-image: url('<?php echo esc_url($crypto_posts[1]['image']); ?>');"></div>
          </div>

          <!-- متن -->
          <p class="text-justify font-bold transition-colors duration-300 group-hover:text-secondary">
            <?php echo esc_html($crypto_posts[1]['title']); ?>
          </p>

          <!-- زمان -->
          <div class="flex justify-end gap-1 items-center">
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
            <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($crypto_posts[1]['time_diff']); ?></p>
          </div>
        </a>
        <?php endif; ?>


      </div>
      <!-- پایان دو باکس اول -->

      <!-- دو باکس دوم -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- آیتم ۳ -->
        <?php if (isset($crypto_posts[2])): ?>
        <a href="<?php echo esc_url($crypto_posts[2]['link']); ?>" class="flex border-b md:border-0 md:pb-0 pb-4 md:border-l border-border md:pl-4 flex-col gap-4 group cursor-pointer transition-colors duration-300 ">
          <!-- عکس -->
          <div class="h-[260px] overflow-hidden">
            <div class="h-full bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
              style="background-image: url('<?php echo esc_url($crypto_posts[2]['image']); ?>');"></div>
          </div>

          <!-- متن -->
          <p class="text-justify font-bold transition-colors duration-300 group-hover:text-secondary">
            <?php echo esc_html($crypto_posts[2]['title']); ?>
          </p>

          <!-- زمان -->
          <div class="flex justify-end gap-1 items-center">
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
            <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($crypto_posts[2]['time_diff']); ?></p>
          </div>
        </a>
        <?php endif; ?>


        <!-- آیتم ۴ -->
        <?php if (isset($crypto_posts[3])): ?>
        <a href="<?php echo esc_url($crypto_posts[3]['link']); ?>" class="flex flex-col gap-4 group cursor-pointer transition-colors duration-300 ">
          <!-- عکس -->
          <div class="h-[260px] overflow-hidden">
            <div class="h-full bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
              style="background-image: url('<?php echo esc_url($crypto_posts[3]['image']); ?>');"></div>
          </div>

          <!-- متن -->
          <p class="text-justify font-bold transition-colors duration-300 group-hover:text-secondary">
            <?php echo esc_html($crypto_posts[3]['title']); ?>
          </p>

          <!-- زمان -->
          <div class="flex justify-end gap-1 items-center">
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
            <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($crypto_posts[3]['time_diff']); ?></p>
          </div>
        </a>
        <?php endif; ?>


      </div>
      <!-- پایان دو باکس دوم -->

    </div>

  </div>

  <!--End right section-->

  <!--start left section-->
  <?php
  // Get crypto section settings
  $crypto_settings = banker_get_crypto_section_settings();

  // WordPress query for gold and currency posts
  $gold_query = new WP_Query(array(
    'cat' => $crypto_settings['gold_category'],
    'posts_per_page' => $crypto_settings['gold_posts_count'], // 1 for main image + 8 for news list
    'post_status' => 'publish',
    
  ));
  
  $gold_posts = array();
  if ($gold_query->have_posts()) {
    while ($gold_query->have_posts()) {
      $gold_query->the_post();
      $gold_posts[] = array(
        'title' => get_the_title(),
        'link' => get_permalink(),
        'image' => get_the_post_thumbnail_url(get_the_ID(), 'full'),
        'excerpt' => get_the_excerpt(),
        'category' => get_the_category()[0]->name ?? '',
        'date' => get_the_date('j F Y'),
        'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
      );
    }
    wp_reset_postdata();
  }
  ?>
  
  <?php if (!empty($gold_posts)): ?>
  <div class="w-full md:w-1/3  h-full flex flex-col ">
    <div class="flex justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($crypto_settings['gold_title']); ?>
      </h4>
      <div class="flex items-center gap-2">
        <a href="#" class="text-[12px] text-secondary  font-medium">
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
    <?php if (isset($gold_posts[0])): ?>
    <a href="<?php echo esc_url($gold_posts[0]['link']); ?>" class="relative mt-4 flex flex-col gap-2 items-center justify-center h-[164px] overflow-hidden group">

      <!-- تصویر به عنوان لایه جدا -->
      <div class="absolute inset-0 h-full bg-cover bg-center transition-transform duration-500 ease-in-out group-hover:scale-110"
        style="background-image: url('<?php echo esc_url($gold_posts[0]['image']); ?>');"></div>

      <!-- overlay آبی -->
      <div class="absolute inset-0 bg-primary/80 pointer-events-none"></div>

      <!-- محتوا -->
      <div class="relative flex flex-col items-center gap-2 text-white z-10">
        <!-- زمان -->
        <div class="flex items-center gap-2">
          <span>
            <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.5001 6.66658H2.50006M11.1667 1.33325V3.99992M5.83339 1.33325V3.99992M5.70006 14.6666H11.3001C12.4202 14.6666 12.9802 14.6666 13.408 14.4486C13.7844 14.2569 14.0903 13.9509 14.2821 13.5746C14.5001 13.1467 14.5001 12.5867 14.5001 11.4666V5.86659C14.5001 4.74648 14.5001 4.18643 14.2821 3.7586C14.0903 3.38228 13.7844 3.07632 13.408 2.88457C12.9802 2.66659 12.4202 2.66659 11.3001 2.66659H5.70006C4.57996 2.66659 4.0199 2.66659 3.59208 2.88457C3.21576 3.07632 2.90979 3.38228 2.71805 3.7586C2.50006 4.18643 2.50006 4.74648 2.50006 5.86658V11.4666C2.50006 12.5867 2.50006 13.1467 2.71805 13.5746C2.90979 13.9509 3.21576 14.2569 3.59208 14.4486C4.0199 14.6666 4.57996 14.6666 5.70006 14.6666Z" stroke="#F6F6F6" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </span>
          <span class="text-[12px] pt-[3px]"><?php echo esc_html($gold_posts[0]['time_diff']); ?></span>
        </div>

        <!-- عنوان -->
        <p class="font-bold text-lg"><?php echo esc_html($gold_posts[0]['title']); ?></p>
      </div>
    </a>
    <?php endif; ?>

    <div class="px-4 bg-lightBg">
      <?php 
      // Display up to 8 news items starting from index 1 (index 0 is used for main image)
      for ($i = 1; $i < count($gold_posts) && $i <= 8; $i++): 
        $is_last = ($i == count($gold_posts) - 1) || ($i == 8);
      ?>
      <div class="flex group gap-2 py-6 <?php echo !$is_last ? 'border-b border-border' : ''; ?>">
        <span class="w-[7px] h-[10px] bg-secondary mt-2 rounded-full inline-block"></span>
        <a href="<?php echo esc_url($gold_posts[$i]['link']); ?>" class="text-[14px] w-11/12 transition-colors duration-300 group-hover:text-secondary font-semibold mt-2 block">
          <?php echo esc_html($gold_posts[$i]['title']); ?>
        </a>
      </div>
      <?php endfor; ?>
    </div>
  </div>

  <!--End left section-->
  <?php endif; ?>

</section>
<!--پایان بخش ارز دیجیتال و طلا و ارز-->
<?php endif; ?>