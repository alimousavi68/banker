<?php
$post_id = get_the_ID();
$content = get_the_content();
?>

<article class="bg-white border-border  -lg px-1 lg:px-2">



    <!-- Main Content -->
    <div class="prose prose-lg max-w-none">
        <div class="text-black leading-relaxed space-y-4">



            <?php
            // Apply content filters and display
            echo apply_filters('the_content', $content);


            // add source 
            // مقادیر فعلی فیلدهای منبع (اختیاری)
            $source_name = get_post_meta($post->ID, '_banker_source_name', true);
            $source_link = get_post_meta($post->ID, '_banker_source_link', true);
            if (!empty($source_name) || !empty($source_link)) {
                echo '<p class="text-sm text-gray-500">منبع: <a href="' . esc_url($source_link) . '" target="_blank">' . esc_html($source_name) . '</a></p>';
            }
            ?>


        </div>
    </div>


</article>

<style>
    /* Custom styles for content */
    .prose h1,
    .prose h2,
    .prose h3,
    .prose h4,
    .prose h5,
    .prose h6 {
        color: #000;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .prose h2 {
        font-size: 1.5rem;
        padding-bottom: 0.5rem;
    }

    .prose h3 {
        font-size: 1.25rem;
    }

    .prose p {
        margin-bottom: 1rem;
        line-height: 180%;
        font-size: 18px;
    }

    .prose img {
        border-radius: 8px;
        margin: 1.5rem auto;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .prose blockquote {
        border-right: 4px solid #3b82f6;
        background: #f8fafc;
        padding: 1rem 1.5rem;
        margin: 1.5rem 0;
        border-radius: 0 8px 8px 0;
        font-style: italic;
    }

    .prose ul {
        list-style-type: none;
        padding-right: 0;
        margin: 1.5rem 0;
    }

    .prose ul li {
        position: relative;
        padding-right: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 180%;
        font-size: 17px;
        color: #202020;
    }

    .prose ul li::before {
        content: "";
        position: absolute;
        right: 0.25rem;
        top: 0.65rem;
        width: 8px;
        height: 8px;
        background-color: var(--color-secondary, #CD3737);
        border-radius: 2px;
        transform: rotate(45deg);
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .prose ul li:hover::before {
        background-color: var(--color-primary, #004A8F);
        transform: rotate(90deg) scale(1.15);
    }

    .prose ol {
        list-style-type: none;
        counter-reset: section;
        padding-right: 0;
        margin: 1.5rem 0;
    }

    .prose ol li {
        position: relative;
        padding-right: 1.75rem;
        margin-bottom: 0.75rem;
        line-height: 180%;
        font-size: 17px;
        color: #202020;
    }

    .prose ol li::before {
        counter-increment: section;
        content: counter(section, decimal) ".";
        position: absolute;
        right: 0.25rem;
        font-weight: 700;
        color: var(--color-primary, #004A8F);
    }

    .prose a {
        color: #3b82f6;
        text-decoration: underline;
    }

    .prose a:hover {
        color: #1d4ed8;
    }

    @media print {
        .prose {
            font-size: 12pt;
            line-height: 1.6;
        }
    }
</style>