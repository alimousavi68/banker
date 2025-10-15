<?php
// Get history section settings from customizer
$history_settings = banker_get_history_section_settings();

// Query for History and Economy section (5 posts from category 8)
$history_posts = new WP_Query(array(
    'cat' => $history_settings['main_category'],
    'posts_per_page' => $history_settings['main_posts_count'],
    'post_status' => 'publish',
    'offset' => 1,
));

// Query for Notes section (3 posts from category 8)
$notes_posts = new WP_Query(array(
    'cat' => $history_settings['notes_category'],
    'posts_per_page' => $history_settings['notes_posts_count'],
    'post_status' => 'publish',

));
?>

<!--شروع بخش تاریخ و اقتصاد -->
<section class="mt-8 md:pb-8 max-w-[1400px] mx-auto px-4  sm:px-4 lg:px-6 border-border border-b flex flex-col md:flex-row gap-4 ">
  <div class="w-full md:border-l md:border-border md:ml-4 md:pl-4 md:w-3/4">
    <div class="flex justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($history_settings['main_title']); ?>
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
    <?php if ($history_posts->have_posts()) : ?>
    <div class="flex flex-col md:flex-row mt-4  gap-4">
      <div class="w-full md:w-1/2 md:border-l md:ml-4 md:pl-4 border-border">
        <?php 
        $post_count = 0;
        while ($history_posts->have_posts() && $post_count < 4) : 
            $history_posts->the_post(); 
            $post_count++;
            $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
            if (!$featured_image) {
                $featured_image = get_template_directory_uri() . '/assets/images/tarickImg.jpg';
            }
            $category = get_the_category();
            $category_name = !empty($category) ? $category[0]->name : 'تاریخ و اقتصاد';
            $border_class = ($post_count < 4) ? 'border-b' : '';
        ?>
        <a href="<?php the_permalink(); ?>" class="flex <?php echo $border_class; ?> group border-border gap-4 py-4 items-center cursor-pointer transition duration-300 no-underline">
          <!-- تصویر -->
          <div class="overflow-hidden">
            <img src="<?php echo esc_url($featured_image); ?>"
              class="h-[100px] w-[148px] transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-80"
              alt="<?php the_title_attribute(); ?>">
          </div>

          <!-- متن -->
          <div class="flex flex-col gap-3">
            <p class="bg-lightBg text-secondary text-[10px] py-[2px] px-2 w-fit">
              <?php echo esc_html($category_name); ?>
            </p>
            <h6 class="font-semibold text-black text-[14px] transition-colors duration-300 group-hover:text-secondary line-clamp-2">
              <?php the_title(); ?>
            </h6>
          </div>
        </a>
        <?php endwhile; ?>

      </div>
      <?php 
      // Reset query and get the 5th post for featured section
      $history_posts->rewind_posts();
      $featured_post_count = 0;
      while ($history_posts->have_posts()) : 
          $history_posts->the_post(); 
          $featured_post_count++;
          if ($featured_post_count == 5) : // Show the 5th post as featured
              $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
              if (!$featured_image) {
                  $featured_image = get_template_directory_uri() . '/assets/images/tarickImg.jpg';
              }
              $excerpt = get_the_excerpt();
              if (empty($excerpt)) {
                  $excerpt = wp_trim_words(get_the_content(), 30, '...');
              }
      ?>
      <a href="<?php the_permalink(); ?>" class="flex w-full md:w-1/2 gap-6 flex-col group cursor-pointer transition duration-300 rounded p-2 no-underline">
        <!-- تصویر -->
        <div class="overflow-hidden">
          <img src="<?php echo esc_url($featured_image); ?>"
            class="h-[260px] w-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-105 group-hover:brightness-110"
            alt="<?php the_title_attribute(); ?>">
        </div>

        <!-- عنوان -->
        <h2 class="font-normal text-lg text-black transition-colors duration-300 group-hover:text-secondary">
          <?php the_title(); ?>
        </h2>

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
          <p class="text-[10px] pt-[3px] text-grayText"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' پیش'; ?></p>
        </div>

        <!-- توضیحات -->
        <p class="text-grayText text-[14px] font-medium line-clamp-3">
          <?php echo esc_html($excerpt); ?>
        </p>
      </a>
      <?php 
          endif;
      endwhile; 
      ?>

    </div>
    <?php endif; ?>

  </div>


  <!-- // نمایش 3 پست آخر برای یادداشت -->
  <div class="w-full md:w-1/4 ">
    <div class="flex justify-between items-center">
      <h4 class="font-medium text-2xl text-black">
        <?php echo esc_html($history_settings['notes_title']); ?>
      </h4>

    </div>
    <div class="space-y-[2px] mt-2 mb-5">
      <div class="border-t-2  border-dotted border-border"></div>
      <div class="border-t-2  border-dotted border-border"></div>
      <div class="border-t-2  border-dotted border-border"></div>
    </div>
    
    <?php if ($notes_posts->have_posts()) : ?>
      <?php 
      $notes_count = 0;
      while ($notes_posts->have_posts() && $notes_count < 3) : 
          $notes_posts->the_post(); 
          $notes_count++;
          
          // Get post type from meta box
          $post_type_meta = get_post_meta(get_the_ID(), '_banker_post_type', true);
          
          // Get custom author data if post type is 'note'
          if ($post_type_meta === 'note') {
              $custom_author_name = get_post_meta(get_the_ID(), '_banker_note_author', true);
              $custom_author_image_id = get_post_meta(get_the_ID(), '_banker_note_author_image', true);
              
              // Use custom author name if available, otherwise fallback to default
              $author_name = !empty($custom_author_name) ? $custom_author_name : get_the_author();
              
              // Use custom author image if available, otherwise fallback to default
              if (!empty($custom_author_image_id)) {
                  $author_avatar = wp_get_attachment_image_url($custom_author_image_id, 'thumbnail');
              } else {
                  $author_avatar = get_avatar_url(get_the_author_meta('ID'), array('size' => 32));
              }
          } else {
              // For non-note posts, use default author data
              $author_name = get_the_author();
              $author_avatar = get_avatar_url(get_the_author_meta('ID'), array('size' => 32));
          }
          
          // Fallback to default avatar if no avatar is found
          if (!$author_avatar) {
              $author_avatar = get_template_directory_uri() . '/assets/images/default-avatar.svg';
          }
          
          $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'medium');
          $excerpt = get_the_excerpt();
          if (empty($excerpt)) {
              $excerpt = wp_trim_words(get_the_content(), 15, '...');
          }
          
          // Check if post has featured image to determine display style
          if ($featured_image) : // Post with image
      ?>
      
      <a href="<?php the_permalink(); ?>" class="block overflow-hidden group no-underline border-b border-border mb-2">
        <img src="<?php echo esc_url($featured_image); ?>"
          alt="<?php the_title_attribute(); ?>"
          class="object-cover w-full h-[140px] scale-100 transition-transform duration-500 ease-in-out group-hover:scale-105 group-hover:brightness-110">

        <div class="<?php echo ($notes_count < 3) ? 'border-b border-border' : ''; ?> py-4 text-right">
          <div class="flex gap-3">
            <span class=" flex-shrink-0">
              <svg width="20" height="20" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M1.583 13.3212C0.553 12.2272 0 11.0002 0 9.01124C0 5.51124 2.457 2.37424 6.03 0.823242L6.923 2.20124C3.588 4.00524 2.936 6.34624 2.676 7.82224C3.213 7.54424 3.916 7.44724 4.605 7.51124C6.409 7.67824 7.831 9.15924 7.831 11.0002C7.831 11.9285 7.46225 12.8187 6.80587 13.4751C6.1495 14.1315 5.25926 14.5002 4.331 14.5002C3.81765 14.4958 3.31031 14.3893 2.83853 14.1869C2.36675 13.9845 1.93995 13.6902 1.583 13.3212ZM11.583 13.3212C10.553 12.2272 10 11.0002 10 9.01124C10 5.51124 12.457 2.37424 16.03 0.823242L16.923 2.20124C13.588 4.00524 12.936 6.34624 12.676 7.82224C13.213 7.54424 13.916 7.44724 14.605 7.51124C16.409 7.67824 17.831 9.15924 17.831 11.0002C17.831 11.9285 17.4623 12.8187 16.8059 13.4751C16.1495 14.1315 15.2593 14.5002 14.331 14.5002C13.8176 14.4958 13.3103 14.3893 12.8385 14.1869C12.3667 13.9845 11.94 13.6902 11.583 13.3212Z" fill="#CD3737" />
              </svg>
            </span>
            <p class="font-normal text-[14px] text-black transition-colors duration-300 group-hover:text-secondary line-clamp-2">
              <?php the_title(); ?>
            </p>
          </div>

          <div class="flex items-center gap-2 mt-2">
            <img src="<?php echo esc_url($author_avatar); ?>" class="w-8 h-8 rounded-full" alt="<?php echo esc_attr($author_name); ?>">
            <span class="text-grayText font-semibold text-[12px]"><?php echo esc_html($author_name); ?></span>
          </div>
        </div>
      </a>

      <?php else : // Post without image - simple quote ?>
      
      <!--start Quote section-->
      <div class="<?php echo ($notes_count < 3) ? 'border-b border-border' : ''; ?> py-4 text-right">
        <a href="<?php the_permalink(); ?>" class="flex items-center gap-3 group cursor-pointer transition duration-300 no-underline">
          <span class="flex-shrink-0 pt-[2px]">
            <svg width="14" height="14" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M1.583 13.3212C0.553 12.2272 0 11.0002 0 9.01124C0 5.51124 2.457 2.37424 6.03 0.823242L6.923 2.20124C3.588 4.00524 2.936 6.34624 2.676 7.82224C3.213 7.54424 3.916 7.44724 4.605 7.51124C6.409 7.67824 7.831 9.15924 7.831 11.0002C7.831 11.9285 7.46225 12.8187 6.80587 13.4751C6.1495 14.1315 5.25926 14.5002 4.331 14.5002C3.81765 14.4958 3.31031 14.3893 2.83853 14.1869C2.36675 13.9845 1.93995 13.6902 1.583 13.3212ZM11.583 13.3212C10.553 12.2272 10 11.0002 10 9.01124C10 5.51124 12.457 2.37424 16.03 0.823242L16.923 2.20124C13.588 4.00524 12.936 6.34624 12.676 7.82224C13.213 7.54424 13.916 7.44724 14.605 7.51124C16.409 7.67824 17.831 9.15924 17.831 11.0002C17.831 11.9285 17.4623 12.8187 16.8059 13.4751C16.1495 14.1315 15.2593 14.5002 14.331 14.5002C13.8176 14.4958 13.3103 14.3893 12.8385 14.1869C12.3667 13.9845 11.94 13.6902 11.583 13.3212Z" fill="#CD3737" />
            </svg>
          </span>

          <p class="font-normal text-[14px] text-black transition-colors duration-300 group-hover:text-secondary line-clamp-2">
            <?php the_title(); ?>
          </p>
        </a>

        <div class="flex group items-center gap-2 mt-2 ">
          <img src="<?php echo esc_url($author_avatar); ?>" class="w-8  h-8 rounded-full" alt="<?php echo esc_attr($author_name); ?>">
          <span class="text-grayText font-semibold text-[12px]"><?php echo esc_html($author_name); ?></span>
        </div>
      </div>
      <!--end Quote section-->
      
      <?php endif; ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</section>
<!--پایان بخش تاریخ و اقتصاد-->