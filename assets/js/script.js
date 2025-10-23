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

  // --- News Ticker (merged from ticker.js) ---
  function outerWidth(el){
    var s = window.getComputedStyle(el);
    var ml = parseFloat(s.marginLeft) || 0;
    var mr = parseFloat(s.marginRight) || 0;
    return el.offsetWidth + ml + mr;
  }
  function ensureTickerContent(track){
    if (!track) return;
    var container = track.parentElement;
    if (!container) return;
    if (!track.dataset.originalCount){
      track.dataset.originalCount = track.children.length;
    }
    var originalCount = parseInt(track.dataset.originalCount, 10);
    var containerWidth = container.offsetWidth;
    var trackWidth = track.scrollWidth;
    var safety = 0;
    while (trackWidth < containerWidth * 2 && safety < 50){
      var children = Array.from(track.children).slice(0, originalCount);
      children.forEach(function(child){
        track.appendChild(child.cloneNode(true));
      });
      trackWidth = track.scrollWidth;
      safety++;
    }
  }
  function stopTickerLoop(track){
    var st = track._tickerState;
    if (st && st.rafId){
      cancelAnimationFrame(st.rafId);
      st.rafId = null;
    }
  }
  function startTickerLoop(track){
    track.style.animation = 'none';
    var state = track._tickerState || { pos: 0, speed: 0.5, rafId: null };
    track._tickerState = state;
    function step(){
      state.pos -= state.speed;
      track.style.transform = 'translateX(' + state.pos + 'px)';
      var first = track.firstElementChild;
      if (first){
        var w = outerWidth(first);
        if (-state.pos >= w){
          track.appendChild(first);
          state.pos += w;
          track.style.transform = 'translateX(' + state.pos + 'px)';
        }
      }
      state.rafId = requestAnimationFrame(step);
    }
    stopTickerLoop(track);
    state.rafId = requestAnimationFrame(step);
  }
  function initTicker(){
    var tracks = document.querySelectorAll('.banker-news-ticker .ticker-track');
    tracks.forEach(function(track){
      ensureTickerContent(track);
      startTickerLoop(track);
    });
    var timeout;
    window.addEventListener('resize', function(){
      clearTimeout(timeout);
      timeout = setTimeout(function(){
        tracks.forEach(function(track){
          stopTickerLoop(track);
          var st = track._tickerState; if (st) { st.pos = 0; }
          track.style.transform = 'translateX(0)';
          var originalCount = parseInt(track.dataset.originalCount || track.children.length, 10);
          while (track.children.length > originalCount){ track.removeChild(track.lastChild); }
          ensureTickerContent(track);
          startTickerLoop(track);
        });
      }, 200);
    });
  }

  function init(){
    initMenu();
    initWordLimit();
    initSubmenus();
    initTicker();
  }

  if (document.readyState === 'loading'){
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
  