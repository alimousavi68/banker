// Unified app script: mobile menu, word limit, submenu toggles, and news ticker
(function(){
  'use strict';

  function initMenu(){
    var menuBtn = document.getElementById('menu-btn');
    var mobileMenu = document.getElementById('mobile-menu');
    var closeMenuBtn = document.getElementById('close-menu');
    var overlay = document.getElementById('overlay');

    function openMenu(){
      if (mobileMenu) mobileMenu.classList.remove('translate-x-full');
      if (overlay) overlay.classList.remove('hidden');
      if (document && document.body) document.body.classList.add('overflow-hidden');
    }
    function closeMenu(){
      if (mobileMenu) mobileMenu.classList.add('translate-x-full');
      if (overlay) overlay.classList.add('hidden');
      if (document && document.body) document.body.classList.remove('overflow-hidden');
    }

    if (menuBtn) menuBtn.addEventListener('click', openMenu);
    if (closeMenuBtn) closeMenuBtn.addEventListener('click', closeMenu);
    if (overlay) overlay.addEventListener('click', closeMenu);
  }

  function initWordLimit(){
    var WORD_LIMIT = 15;
    var nodes = document.querySelectorAll('.limit-words-10');
    nodes.forEach(function(el){
      var text = el.innerText || '';
      var parts = text.split(' ');
      if (parts.length > WORD_LIMIT){
        el.innerText = parts.slice(0, WORD_LIMIT).join(' ') + '...';
      }
    });
  }

  function initSubmenus(){
    var submenuButtons = document.querySelectorAll('[id^="submenu-btn"]');
    submenuButtons.forEach(function(button){
      button.addEventListener('click', function(){
        var buttonId = this.id;
        var itemId = buttonId.replace('submenu-btn-', '');
        var submenu = document.getElementById('submenu-' + itemId);
        var icon = document.getElementById('submenu-icon-' + itemId);
        if (submenu){
          submenu.classList.toggle('hidden');
          submenu.classList.toggle('flex');
        }
        if (icon){
          icon.classList.toggle('rotate-180');
        }
      });
    });

    var fallbackBtn = document.getElementById('submenu-btn-fallback');
    var fallbackSubmenu = document.getElementById('submenu-fallback');
    var fallbackIcon = document.getElementById('submenu-icon-fallback');
    if (fallbackBtn && fallbackSubmenu && fallbackIcon){
      fallbackBtn.addEventListener('click', function(){
        fallbackSubmenu.classList.toggle('hidden');
        fallbackSubmenu.classList.toggle('flex');
        fallbackIcon.classList.toggle('rotate-180');
      });
    }
  }

  

  function init(){
    initMenu();
    initWordLimit();
    initSubmenus();

    // Initialize jQuery Breaking News Ticker (replaces previous custom marquee)
    if (window.jQuery && typeof jQuery.fn.breakingNews === 'function'){
      jQuery('#banker-breaking-news').breakingNews({
				direction: 'rtl',
        delayTimer: 500,
        scrollSpeed: 1,
        stopOnHover: true
			});
    }
  }

  if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
  