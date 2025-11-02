<?php
// Get banker view section settings from customizer
$banker_view_settings = banker_get_banker_view_section_settings();

// WordPress query for the main banker view post
$main_banker_view_query = new WP_Query(array(
  'cat' => $banker_view_settings['main_category'],
  'posts_per_page' => 1,
  'post_status' => 'publish',
));

// WordPress query for the 4 smaller banker view posts
$small_banker_view_query = new WP_Query(array(
  'cat' => $banker_view_settings['main_category'],
  'posts_per_page' => 4,
  'offset' => 1, // Exclude the main post
  'post_status' => 'publish',
));

// WordPress query for category ID 8 (what else is new section)
$news_query = new WP_Query(array(
  'cat' => $banker_view_settings['news_category'],
  'posts_per_page' => $banker_view_settings['news_posts_count'],
  'post_status' => 'publish',

));

$news_posts = array();
if ($news_query->have_posts()) {
  while ($news_query->have_posts()) {
    $news_query->the_post();
    $post_id = get_the_ID();
    $news_posts[] = array(
      'title' => get_the_title(),
      'link' => get_permalink(),
      'image' => get_the_post_thumbnail_url($post_id, 'full'),
      'excerpt' => get_the_excerpt(),
      'category' => get_the_category($post_id)[0]->name ?? '',
      'date' => get_the_date('Y-m-d H:i:s'),
      'time_diff' => human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'
    );
  }
  wp_reset_postdata();
}
?>

<?php if ($main_banker_view_query->have_posts() || $small_banker_view_query->have_posts()): ?>
  <!--شروع بخش نگاه بنکر-->
  <section class=" mt-8 py-16  bg-primary">
    <div class="flex flex-col md:flex-row max-w-[1400px] mx-auto px-4  sm:px-4 lg:px-6 ">

      <div class="w-full md:w-2/3 ">
        <div class="flex justify-between items-center">
          <h4 class="font-medium text-2xl text-white">
            <?php echo esc_html($banker_view_settings['main_title']); ?>
          </h4>
          <div class="flex items-center gap-2">
            <a href="<?php echo esc_url(get_category_link($banker_view_settings['main_category'])); ?>" class="text-[12px] text-white  font-medium">
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
        <!--start boxes-->
        <div class="flex flex-col md:flex-row mt-4">
          <?php if ($main_banker_view_query->have_posts()): $main_banker_view_query->the_post();
            $main_image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_672x378') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
          ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="w-full md:w-1/2 md:border-l md:pl-4 md:ml-4 border-[#535353] flex flex-col gap-4 group cursor-pointer  transition-colors duration-300">
              <!-- عکس -->
              <div class="overflow-hidden">
                <img src="<?php echo esc_url($main_image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
              </div>

              <!-- عنوان -->
              <p class="font-bold text-white text-[18px] transition-colors duration-300 group-hover:text-secondary">
                <?php echo esc_html(get_the_title()); ?>
              </p>

              <!-- توضیح -->
              <p class="text-justify text-gray-300 text-[14px] transition-colors duration-300 line-clamp-3">
                <?php echo esc_html(get_the_excerpt()); ?>
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
                <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html(human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'); ?></p>
              </div>
            </a>
          <?php endif; ?>
          <?php wp_reset_postdata(); ?>

          <div class="w-full mt-4 md:mt-0 md:w-1/2">

            <?php while ($small_banker_view_query->have_posts()): $small_banker_view_query->the_post();
              $small_image_url = get_the_post_thumbnail_url(get_the_ID(), 'banker_411x231') ?: get_template_directory_uri() . '/assets/images/default-image.jpg';
            ?>
              <a href="<?php echo esc_url(get_permalink()); ?>" class="flex border-b border-[#535353] gap-4 pb-4 items-center group cursor-pointer transition duration-300 ">
                <!-- تصویر -->
                <div class="w-1/3 overflow-hidden">
                  <img src="<?php echo esc_url($small_image_url); ?>"
                    class="w-[140px] h-auto transition duration-300 group-hover:scale-105 group-hover:brightness-110"
                    alt="<?php echo esc_attr(get_the_title()); ?>">
                </div>

                <!-- متن -->
                <div class="flex w-2/3 flex-col gap-3">

                  <p class="font-semibold text-white text-[14px] transition-colors duration-300 group-hover:text-secondary">
                    <?php echo esc_html(get_the_title()); ?>
                  </p>
                </div>
              </a>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>

          </div>

        </div>
        <!--end boxes-->

      </div>
    <?php endif; ?>


    <!--شروع بخش دیگه چه خبر-->
    <div class="w-full md:w-1/3 md:border-r border-[#535353] md:mr-4 md:pr-4">
      <div class="flex justify-between items-center">
        <h4 class="font-medium text-2xl text-white">
          دیگه چه خبر
        </h4>
        <div class="flex items-center gap-2 text-white">
          <a href="<?php echo esc_url(get_category_link($banker_view_settings['news_category'])); ?>" class="text-[12px] text-white font-medium">
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

      <?php if (!empty($news_posts)): ?>
        <ol class="custom-counter ">
          <?php foreach ($news_posts as $news_post): ?>
            <li>
              <a href="<?php echo esc_url($news_post['link']); ?>" class=" hover:text-secondary transition cursor-pointer">
                <?php echo esc_html($news_post['title']); ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ol>
      <?php

      endif; ?>

    </div>
    <!--پایان بخش دیگه چه خبر-->
    </div>

  </section>
  <!--پایان بخش نگاه بنکر-->