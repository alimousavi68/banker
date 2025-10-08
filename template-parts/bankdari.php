<?php
// Query for banking posts
$banking_query = new WP_Query(array(
    'cat' => 8, // Banking category ID
    'posts_per_page' => 5, // 1 for main section + 4 for sidebar
    'post_status' => 'publish'
));

// Prepare posts array for Banking section
$banking_posts = array();

if ($banking_query->have_posts()) {
    while ($banking_query->have_posts()) {
        $banking_query->the_post();
        $banking_posts[] = array(
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
?>

<?php if (!empty($banking_posts) && count($banking_posts) > 0): ?>
<!--شروع بخش بانکداری-->
<section class="mt-8 max-w-[1400px] mx-auto px-4 sm:px-4 lg:px-6 ">
  <div class="flex  justify-between items-center">
    <h4 class="font-medium text-2xl text-black">
      بانکداری
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
  <!--right section-->
  <div class="flex flex-col md:flex-row border-b border-border pb-8 pt-5 ">
    <?php if (isset($banking_posts[0])): ?>
    <a href="<?php echo esc_url($banking_posts[0]['link']); ?>" class="w-full md:w-1/2  flex-col gap-6 group block cursor-pointer">
      <!-- عکس -->
      <div class="h-[360px] mt-4 overflow-hidden">
        <img src="<?php echo esc_url($banking_posts[0]['image']); ?>" alt="<?php echo esc_attr($banking_posts[0]['title']); ?>" class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
      </div>

      <!-- متن -->
      <p class="transition-colors duration-300 text-[22px] mt-4 group-hover:text-secondary">
        <?php echo esc_html($banking_posts[0]['title']); ?>
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
        <p class="text-[10px] pt-[3px] text-grayText"><?php echo esc_html($banking_posts[0]['time_diff']); ?></p>
      </div>
    </a>
    <?php endif; ?>



    <!--left section-->
    <div class="w-full md:w-1/2 md:border-r border-border md:mr-4 md:pr-4 flex flex-col">

      <?php for ($i = 1; $i < 5 && $i < count($banking_posts); $i++): ?>
      <!-- آیتم <?php echo $i; ?> -->
      <a href="<?php echo esc_url($banking_posts[$i]['link']); ?>" class="flex gap-4 py-4 <?php echo ($i < 4) ? 'border-b border-border' : ''; ?> items-start md:items-center group cursor-pointer transition-colors duration-300 ">
        <!-- عکس -->
        <div class="w-1/3 md:w-1/4 overflow-hidden">
          <img src="<?php echo esc_url($banking_posts[$i]['image']); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?php echo esc_attr($banking_posts[$i]['title']); ?>">
        </div>

        <!-- متن -->
        <div class="flex w-3/4 md:w-3/4 flex-col gap-3">
          <p class="bg-lightBg text-secondary text-[10px] py-[2px] px-2 w-fit">
            <?php echo esc_html($banking_posts[$i]['category']); ?>
          </p>
          <p class="font-semibold text-black text-[14px] transition-colors duration-300 group-hover:text-secondary">
            <?php echo esc_html($banking_posts[$i]['title']); ?>
          </p>
          <p class="text-[14px] limit-words-10 text-justify text-grayText">
            <?php echo esc_html($banking_posts[$i]['excerpt']); ?>
          </p>
        </div>
      </a>
      <?php endfor; ?>

    </div>

  </div>
</section>
<!--پایان بخش بانکداری-->
<?php endif; ?>