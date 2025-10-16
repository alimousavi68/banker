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
            ?>
        </div>
    </div>
    
    
</article>

<style>
/* Custom styles for content */
.prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
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

.prose ul, .prose ol {
    margin: 1rem 0;
    padding-right: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
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