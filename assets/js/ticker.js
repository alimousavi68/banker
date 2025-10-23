(function(){
  function ensureTicker(track){
    if (!track) return;
    var container = track.parentElement;
    if (!container) return;

    // ثبت تعداد آیتم‌های اصلی برای مدیریت ریسایز
    if (!track.dataset.originalCount) {
      track.dataset.originalCount = track.children.length;
    }
    var originalCount = parseInt(track.dataset.originalCount, 10);

    var containerWidth = container.offsetWidth;
    var trackWidth = track.scrollWidth;

    // تکثیر آیتم‌ها تا عرض ترک حداقل دو برابر کانتینر شود
    var safety = 0;
    while (trackWidth < containerWidth * 2 && safety < 20) {
      var children = Array.from(track.children).slice(0, originalCount);
      children.forEach(function(child){
        track.appendChild(child.cloneNode(true));
      });
      trackWidth = track.scrollWidth;
      safety++;
    }
  }

  function init(){
    var tracks = document.querySelectorAll('.banker-news-ticker .ticker-track');
    tracks.forEach(function(track){
      ensureTicker(track);
    });

    // تنظیم مجدد روی تغییر اندازه
    var timeout;
    window.addEventListener('resize', function(){
      clearTimeout(timeout);
      timeout = setTimeout(function(){
        tracks.forEach(function(track){
          var originalCount = parseInt(track.dataset.originalCount || track.children.length, 10);
          // حذف کلون‌ها و بازسازی بر اساس اندازه جدید
          while (track.children.length > originalCount) {
            track.removeChild(track.lastChild);
          }
          ensureTicker(track);
        });
      }, 200);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();