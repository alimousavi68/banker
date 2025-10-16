<?php
/**
 * سیستم کامنت اختصاصی قالب Banker
 * شامل فرم ارسال دیدگاه مینیمالی و لیست کامنت‌های تو در تو
 */

// جلوگیری از دسترسی مستقیم
if (post_password_required()) {
    return;
}

$comments_count = get_comments_number();
?>

<div class="banker-comments-section">
    
    <!-- هدر بخش کامنت‌ها -->
    <div class="comments-header mb-8">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-2xl text-black">
                <?php if ($comments_count > 0): ?>
                    دیدگاه‌ها (<?php echo $comments_count; ?>)
                <?php else: ?>
                    دیدگاه‌ها
                <?php endif; ?>
            </h3>
        </div>
        <div class="space-y-[2px] mt-2">
            <div class="border-t-2 border-dotted border-border"></div>
            <div class="border-t-2 border-dotted border-border"></div>
            <div class="border-t-2 border-dotted border-border"></div>
        </div>
    </div>

    <!-- فرم ارسال دیدگاه -->
    <?php if (comments_open()): ?>
    <div class="comment-form-section mb-8">
        <form action="<?php echo site_url('/wp-comments-post.php'); ?>" method="post" id="commentform" class="banker-comment-form">
            
            <!-- طراحی دو ستونه -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- ستون سمت راست: بخش دریافت دیدگاه -->
                <div class="lg:col-span-2">
                    <div class="form-group">
                        <textarea name="comment" 
                                  id="comment" 
                                  rows="8" 
                                  placeholder="دیدگاه شما..." 
                                  required
                                  class="w-full px-4 py-3 border border-border bg-white text-black placeholder-grayText focus:outline-none focus:border-primary transition-colors duration-300 resize-vertical"></textarea>
                    </div>
                </div>

                <!-- ستون سمت چپ: فیلدهای کاربر و دکمه ارسال -->
                <div class="lg:col-span-1">
                    <div class="space-y-4">
                        <?php if (!is_user_logged_in()): ?>
                        <!-- فیلد نام -->
                        <div class="form-group">
                            <input type="text" 
                                   name="author" 
                                   id="author" 
                                   placeholder="نام شما *" 
                                   required
                                   class="w-full px-4 py-3 border border-border bg-white text-black placeholder-grayText focus:outline-none focus:border-primary transition-colors duration-300">
                        </div>
                        
                        <!-- فیلد ایمیل -->
                        <div class="form-group">
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   placeholder="ایمیل شما *" 
                                   required
                                   class="w-full px-4 py-3 border border-border bg-white text-black placeholder-grayText focus:outline-none focus:border-primary transition-colors duration-300">
                        </div>
                        <?php endif; ?>
                        
                        <!-- دکمه ارسال با عرض کامل -->
                        <div class="form-actions">
                            <button type="submit" 
                                    name="submit" 
                                    class="w-full bg-primary text-white px-6 py-3 font-medium hover:bg-opacity-90 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-opacity-50">
                                ارسال دیدگاه
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- فیلدهای مخفی -->
            <input type="hidden" name="comment_post_ID" value="<?php echo get_the_ID(); ?>">
            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            <?php wp_nonce_field('comment_form', 'comment_form_nonce'); ?>
        </form>
    </div>
    <?php endif; ?>

    <div class="comments-area bg-white border border-border rounded-sm p-6 mb-8">
        <?php if (have_comments()) : ?>
            <h3 class="comments-title text-lg font-bold text-black mb-6 flex items-center gap-2">
                <div class="w-1 h-5 bg-secondary rounded"></div>
                <?php
                $comment_count = get_comments_number();
                if ($comment_count == 1) {
                    echo 'یک دیدگاه';
                } else {
                    printf('%s دیدگاه', number_format_i18n($comment_count));
                }
                ?>
            </h3>

            <ol class="comment-list space-y-6">
                <?php
                wp_list_comments(array(
                    'walker' => null,
                    'max_depth' => 3,
                    'style' => 'ol',
                    'callback' => 'banker_custom_comment_template',
                    'end-callback' => null,
                    'type' => 'all',
                    'page' => '',
                    'per_page' => '',
                    'avatar_size' => 48,
                    'reverse_top_level' => null,
                    'reverse_children' => '',
                    'format' => 'html5',
                    'short_ping' => false,
                    'echo' => true
                ));
                ?>
            </ol>

            <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
                <nav class="comment-navigation mt-6 pt-6 border-t border-border">
                    <div class="nav-links flex justify-between">
                        <?php if (get_previous_comments_link()) : ?>
                            <div class="nav-previous">
                                <?php previous_comments_link('دیدگاه‌های قبلی'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (get_next_comments_link()) : ?>
                            <div class="nav-next">
                                <?php next_comments_link('دیدگاه‌های بعدی'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </nav>
            <?php endif; ?>

        <?php endif; ?>

        <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
            <p class="no-comments text-grayText text-sm">امکان ثبت دیدگاه جدید وجود ندارد.</p>
        <?php endif; ?>


    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle inline reply functionality
        const replyLinks = document.querySelectorAll('.comment-reply-link');
        const cancelReplyLink = document.querySelector('#cancel-comment-reply-link');
        const commentForm = document.querySelector('#commentform');
        const originalFormParent = commentForm ? commentForm.parentNode : null;
        
        replyLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const commentId = this.getAttribute('data-commentid');
                const commentItem = document.querySelector('#comment-' + commentId);
                
                if (commentItem && commentForm) {
                    // Move form to the comment
                    commentItem.appendChild(commentForm);
                    
                    // Update form title
                    const respondTitle = document.querySelector('#reply-title');
                    if (respondTitle) {
                        const authorName = commentItem.querySelector('.comment-author .fn').textContent;
                        respondTitle.innerHTML = 'پاسخ به ' + authorName + ' <small><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:inline;">لغو پاسخ</a></small>';
                    }
                    
                    // Set parent comment ID
                    const parentInput = document.querySelector('#comment_parent');
                    if (parentInput) {
                        parentInput.value = commentId;
                    }
                    
                    // Show cancel link
                    const cancelLink = document.querySelector('#cancel-comment-reply-link');
                    if (cancelLink) {
                        cancelLink.style.display = 'inline';
                        cancelLink.addEventListener('click', function(e) {
                            e.preventDefault();
                            
                            // Move form back to original position
                            if (originalFormParent) {
                                originalFormParent.appendChild(commentForm);
                            }
                            
                            // Reset form title
                            if (respondTitle) {
                                respondTitle.innerHTML = 'دیدگاه شما';
                            }
                            
                            // Reset parent ID
                            if (parentInput) {
                                parentInput.value = '0';
                            }
                            
                            // Hide cancel link
                            this.style.display = 'none';
                        });
                    }
                    
                    // Focus on comment textarea
                    const commentTextarea = document.querySelector('#comment');
                    if (commentTextarea) {
                        commentTextarea.focus();
                    }
                }
            });
        });
    });
    </script>

</div>

<style>
/* استایل‌های اختصاصی سیستم کامنت */
.banker-comments-section {
    font-family: 'IranSansX', sans-serif;
}

.comment-item {
    border-bottom: 1px solid #CCCCCC;
    padding: 1.5rem 0;
}

.comment-item:last-child {
    border-bottom: none;
}

.comment-content {
    background: #F6F6F6;
    padding: 1rem;
    margin-bottom: 1rem;
    border-right: 3px solid #004A8F;
}

.comment-meta {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    color: #858585;
}

.comment-author {
    font-weight: 600;
    color: #202020;
}

.comment-date {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.comment-text {
    color: #202020;
    line-height: 1.7;
    margin-bottom: 1rem;
}

.comment-reply-link {
    color: #CD3737;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
}

.comment-reply-link:hover {
    color: #004A8F;
}

/* استایل کامنت‌های تو در تو */
.children {
    margin-right: 2rem;
    margin-top: 1rem;
    border-right: 2px solid #CCCCCC;
    padding-right: 1rem;
}

.children .comment-item {
    border-bottom: 1px solid #E5E5E5;
}

.children .comment-content {
    background: #FAFAFA;
    border-right-color: #CD3737;
}

/* سطح دوم تو در تو */
.children .children {
    margin-right: 1.5rem;
    border-right-color: #858585;
}

.children .children .comment-content {
    background: #F0F0F0;
    border-right-color: #858585;
}



/* ریسپانسیو */
@media (max-width: 768px) {
    .children {
        margin-right: 1rem;
        padding-right: 0.75rem;
    }
    
    .children .children {
        margin-right: 0.75rem;
    }
    
    .comment-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>



<?php
/**
 * تمپلیت سفارشی برای نمایش کامنت‌ها
 */
function banker_custom_comment_template($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    
    // تعیین رنگ و استایل بر اساس عمق کامنت
    $depth_styles = array(
        0 => 'bg-white border-border',
        1 => 'bg-blue-50 border-blue-200 mr-6',
        2 => 'bg-green-50 border-green-200 mr-12',
        3 => 'bg-yellow-50 border-yellow-200 mr-18'
    );
    
    $comment_class = isset($depth_styles[$depth]) ? $depth_styles[$depth] : 'bg-gray-50 border-gray-200 mr-24';
    
    ?>
    <li id="comment-<?php comment_ID(); ?>" class="comment-item">
        <article class="comment-body border rounded-sm p-4 mb-4 <?php echo $comment_class; ?>">
            <div class="comment-header flex items-start gap-3 mb-3">
                <div class="comment-avatar">
                    <?php echo get_avatar($comment, 40, '', '', array('class' => 'rounded-full')); ?>
                </div>
                <div class="comment-meta flex-1">
                    <div class="comment-author text-sm font-medium text-black">
                        <span class="fn"><?php comment_author(); ?></span>
                        <?php if ($comment->user_id && user_can($comment->user_id, 'edit_posts')): ?>
                            <span class="badge bg-secondary text-white text-xs px-2 py-1 rounded mr-2">نویسنده</span>
                        <?php endif; ?>
                    </div>
                    <div class="comment-date text-xs text-grayText">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php comment_date('j F Y'); ?> در <?php comment_time('H:i'); ?>
                        </time>
                    </div>
                </div>
            </div>
            
            <div class="comment-content text-sm text-black leading-relaxed mb-3">
                <?php if ($comment->comment_approved == '0'): ?>
                    <p class="comment-awaiting-moderation text-yellow-600 text-xs mb-2">
                        دیدگاه شما در انتظار تایید است.
                    </p>
                <?php endif; ?>
                <?php comment_text(); ?>
            </div>
            
            <div class="comment-actions flex items-center gap-4">
                <?php 
                comment_reply_link(array_merge($args, array(
                    'add_below' => 'comment',
                    'depth' => $depth,
                    'max_depth' => $args['max_depth'],
                    'before' => '',
                    'after' => '',
                    'reply_text' => 'پاسخ',
                    'class' => 'comment-reply-link text-xs text-secondary hover:text-primary transition-colors'
                )));
                ?>
                
                <?php edit_comment_link('ویرایش', '<span class="edit-link text-xs text-grayText hover:text-secondary transition-colors">', '</span>'); ?>
            </div>
        </article>
    <?php
}
?>