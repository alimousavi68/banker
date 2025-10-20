<?php
/**
 * Template: 404 Not Found (Banker Theme)
 */
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<section class="container mx-auto px-4 py-12">
    <div class="bg-lightBg border border-border rounded-sm p-8 text-center">
        <div class="text-6xl md:text-7xl font-extrabold text-red-600 mb-4">۴۰۴</div>
        <h1 class="text-3xl font-bold text-black mb-3">صفحه مورد نظر پیدا نشد</h1>
        <p class="text-grayText mb-6">می‌توانید به صفحه اصلی برگردید یا جستجو کنید.</p>
        <div class="flex items-center justify-center gap-3 mb-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="bg-secondary text-white px-5 py-2 rounded-sm hover:bg-opacity-90 transition-colors">
                بازگشت به صفحه اصلی
            </a>
        </div>
        <div class="max-w-xl mx-auto">
            <?php get_search_form(); ?>
        </div>
    </div>
</section>

<?php
get_footer();