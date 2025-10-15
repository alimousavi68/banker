<?php
// Get pishkhan section settings from customizer
$pishkhan_settings = banker_get_pishkhan_section_settings();

// Query for pishkhan posts
$pishkhan_query = new WP_Query(array(
  'cat' => $pishkhan_settings['main_category'],
  'posts_per_page' => $pishkhan_settings['main_posts_count'],
  'post_status' => 'publish'
));

// Prepare posts array for News Dashboard
$pishkhan_posts = array();

if ($pishkhan_query->have_posts()) {
  while ($pishkhan_query->have_posts()) {
    $pishkhan_query->the_post();
    $pishkhan_posts[] = array(
      'title' => get_the_title(),
      'link' => get_permalink(),
      'image' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
      'excerpt' => get_the_excerpt(),
      'category' => get_the_category()[0]->name,
      'date' => get_the_date(),
      'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
    );
  }
  wp_reset_postdata();
}

// Query for latest news posts (Latest News section)
$latest_news_args = array(
  'posts_per_page' => $pishkhan_settings['latest_posts_count'],
  'post_status' => 'publish'
);

// Add category filter only if type is 'category'
if ($pishkhan_settings['latest_type'] === 'category') {
  $latest_news_args['cat'] = $pishkhan_settings['latest_category'];
} else {
  // For 'recent' type, order by date (default behavior)
  $latest_news_args['orderby'] = 'date';
  $latest_news_args['order'] = 'DESC';
}

$latest_news_query = new WP_Query($latest_news_args);

// Prepare posts array for Latest News
$latest_news_posts = array();

if ($latest_news_query->have_posts()) {
  while ($latest_news_query->have_posts()) {
    $latest_news_query->the_post();
    $latest_news_posts[] = array(
      'title' => get_the_title(),
      'link' => get_permalink(),
      'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
    );
  }
  wp_reset_postdata();
}
?>

<?php if ((!empty($pishkhan_posts) && count($pishkhan_posts) > 0) || (!empty($latest_news_posts) && count($latest_news_posts) > 0)): ?>
  <!--START pishkhan khabar-->
  <section class="grid grid-cols-1 md:grid-cols-2 border-b  max-w-[1400px] mx-auto px-4  sm:px-4 lg:px-6  border-border pb-8 mt-8">
    <?php if (!empty($pishkhan_posts) && count($pishkhan_posts) > 0): ?>
      <div class="ml-4">
        <h4 class="font-medium text-2xl text-black">
          <?php echo esc_html($pishkhan_settings['main_title']); ?>
        </h4>
        <div class="space-y-[2px] mt-2">
          <div class="border-t-2  border-dotted border-border"></div>
          <div class="border-t-2  border-dotted border-border"></div>
          <div class="border-t-2  border-dotted border-border"></div>
        </div>
        <div>
          <?php for ($i = 0; $i < 3 && $i < count($pishkhan_posts); $i++): ?>
            <a href="<?php echo esc_url($pishkhan_posts[$i]['link']); ?>" class="group block">
              <div class="flex gap-4 py-4 <?php echo ($i < 2) ? 'border-b border-border' : ''; ?> items-start md:items-center">
                <div class="w-1/3 overflow-hidden md:w-1/4">
                  <img src="<?php echo esc_url($pishkhan_posts[$i]['image']); ?>" alt="<?php echo esc_attr($pishkhan_posts[$i]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-80">
                </div>
                <div class="flex w-2/3 md:w-3/4 flex-col gap-3">
                  <p class="bg-lightBg text-secondary text-[10px] py-[2px] px-2 w-fit">
                    <?php echo wp_kses_post($pishkhan_posts[$i]['category']); ?>
                  </p>
                  <p class="font-semibold text-black text-[16px] md:text-[18px] transition-colors duration-300 ease-in-out group-hover:text-secondary">
                    <?php echo esc_html($pishkhan_posts[$i]['title']); ?>
                  </p>

                  <p class="text-[14px] limit-words-10 text-justify text-grayText">
                    <?php echo esc_html($pishkhan_posts[$i]['excerpt']); ?>
                  </p>
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
                    <p class="text-[10px] pt-[3px] text-grayText">
                      <?php echo esc_html($pishkhan_posts[$i]['time_diff']); ?>
                    </p>
                  </div>
                </div>
              </div>
            </a>
          <?php endfor; ?>

        </div>
      </div>
    <?php endif; ?>
    <!--شروع بخش اخرین اخبار -->
    <?php if (!empty($latest_news_posts) && count($latest_news_posts) > 0): ?>
      <div class="md:pr-4 flex flex-col md:flex-row  md:border-r md:border-border">
        <div class="bg-lightBg  md:px-4 w-full md:w-2/3 ml-4 ">
          <h4 class="font-medium text-2xl text-black">
            <?php echo esc_html($pishkhan_settings['latest_title']); ?>
          </h4>
          <div class="space-y-[2px] mt-2">
            <div class="border-t-2  border-dotted border-border"></div>
            <div class="border-t-2  border-dotted border-border"></div>
            <div class="border-t-2  border-dotted border-border"></div>
          </div>
          <!-- تایم‌لاین -->
          <div class="relative mt-4">
            <!-- خط عمودی سمت راست -->
            <div class="absolute top-0 right-3 h-full w-px bg-gray-300"></div>

            <?php for ($i = 0; $i < 6 && $i < count($latest_news_posts); $i++): ?>
              <!-- خبر <?php echo ($i + 1); ?> -->
              <div class="flex items-start <?php echo ($i == 5) ? 'my-5' : 'my-3'; ?> relative">
                <!-- دایره روی خط -->
                <div class="w-[7px] h-[10px] bg-secondary absolute right-[2px] -translate-x-1/2 mt-2 transform rounded-full"></div>

                <div class="mr-6 group">
                  <div class="flex items-center gap-1">
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
                    <p class="text-[10px] <?php echo ($i == 0) ? 'text-grayText' : 'pt-[3px] text-grayText'; ?>"><?php echo esc_html($latest_news_posts[$i]['time_diff']); ?></p>
                  </div>
                  <a href="<?php echo esc_url($latest_news_posts[$i]['link']); ?>" class="text-[14px] transition-colors duration-300 group-hover:text-secondary font-medium mt-2 block">
                    <?php echo esc_html($latest_news_posts[$i]['title']); ?>
                  </a>
                </div>
              </div>
              <?php if ($i < 5 && $i < count($latest_news_posts) - 1): ?>
                <div class="w-[88%] m-auto bg-border h-[1px]"></div>
              <?php endif; ?>
            <?php endfor; ?>
          </div>
        </div>
        <!--پایان بخش اخرین اخبار -->
        <div class="w-full md:w-1/3 md:pr-4 mt-4 md:mt-0  md:border-r border-border flex flex-col gap-6">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif1.gif" class="w-full md:h-[80px]" alt="">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif2.gif" alt="" class="w-full md:h-[80px]">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif3.gif" alt="" class="w-full md:h-[80px]">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif4.gif" alt="" class="w-full md:h-[80px]">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif3.gif" alt="" class="w-full md:h-[80px]">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/gifs/gif1.gif" alt="" class="w-full md:h-[80px]">
        </div>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>