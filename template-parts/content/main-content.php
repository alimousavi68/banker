<?php
$post_id = get_the_ID();
$content = get_the_content();
?>

<article class="bg-white border-border border-b -lg px-1 lg:px-2">
    
   
    
    <!-- Main Content -->
    <div class="prose prose-lg max-w-none">
        <div class="text-black leading-relaxed space-y-4">
            <?php
            // Apply content filters and display
            echo apply_filters('the_content', $content);
            ?>
        </div>
    </div>
    
    <!-- Content Footer -->
    <div class="border-t border-border pt-6 mt-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            
            <!-- Last Updated -->
            <div class="flex items-center gap-2 text-sm text-grayText">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h6"></path>
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10Z"></path>
                </svg>
                <span>آخرین بروزرسانی: <?php echo get_the_modified_date('Y/m/d - H:i'); ?></span>
            </div>
            
            <!-- Print Button -->
            <button 
                onclick="window.print()" 
                class="flex items-center gap-2 px-4 py-2 bg-lightBg border border-border  hover:bg-secondary hover:text-white transition-colors text-sm"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" stroke-width="1.5" viewBox="0 0 24 24" color="currentColor">
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17.5 16H22V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v10h4.5"></path>
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M17.5 20v-4H6.5v4h11Z"></path>
                    <path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M6.5 16V4h11v12"></path>
                </svg>
                چاپ مقاله
            </button>
            
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
    border-bottom: 2px solid #f0f0f0;
    padding-bottom: 0.5rem;
}

.prose h3 {
    font-size: 1.25rem;
}

.prose p {
    margin-bottom: 1rem;
    line-height: 1.8;
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