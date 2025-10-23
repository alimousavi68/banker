// Minimal script to handle mobile menu toggling and avoid 404 errors
(function(){
  document.addEventListener('DOMContentLoaded', function(){
    var openBtn = document.getElementById('menu-btn');
    var closeBtn = document.getElementById('close-menu');
    var mobileMenu = document.getElementById('mobile-menu');
    var overlay = document.getElementById('overlay');

    function openMenu(){
      if (mobileMenu) mobileMenu.classList.remove('translate-x-full');
      if (overlay) overlay.classList.remove('hidden');
    }
    function closeMenu(){
      if (mobileMenu) mobileMenu.classList.add('translate-x-full');
      if (overlay) overlay.classList.add('hidden');
    }

    if (openBtn) openBtn.addEventListener('click', openMenu);
    if (closeBtn) closeBtn.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);
  });
})();