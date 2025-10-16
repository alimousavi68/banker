<?php
$page_id = get_the_ID();
$content = get_the_content();
$last_modified = get_the_modified_date('Y/m/d - H:i');
?>

<article class="bg-white border-border border-b rounded-lg px-1 lg:px-2">
    
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

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show a simple notification
        const notification = document.createElement('div');
        notification.textContent = 'لینک کپی شد!';
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
        document.body.appendChild(notification);
        
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 2000);
    });
}
</script>