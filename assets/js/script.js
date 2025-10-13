const menuBtn = document.getElementById('menu-btn');
const mobileMenu = document.getElementById('mobile-menu');
const closeMenuBtn = document.getElementById('close-menu');
const overlay = document.getElementById('overlay');

// باز کردن منو
menuBtn.addEventListener('click', () => {
  mobileMenu.classList.remove('translate-x-full');
  overlay.classList.remove('hidden');
  document.body.classList.add("overflow-hidden"); //  جلوگیری از اسکرول
});

// بستن منو
function closeMenu() {
  mobileMenu.classList.add('translate-x-full');
  overlay.classList.add('hidden');
  document.body.classList.remove("overflow-hidden"); //  اسکرول دوباره آزاد
}

closeMenuBtn.addEventListener('click', closeMenu);
overlay.addEventListener('click', closeMenu);

// تعداد کلمه مورد نظر
const WORD_LIMIT = 15;

document.querySelectorAll(".limit-words-10").forEach(el => {
  const text = el.innerText;
  const limitedText = text.split(" ").slice(0, WORD_LIMIT).join(" ") + "...";
  el.innerText = limitedText;
});

// Handle dynamic submenu buttons
document.addEventListener('DOMContentLoaded', function() {
  // Handle all submenu buttons (both dynamic and fallback)
  const submenuButtons = document.querySelectorAll('[id^="submenu-btn"]');
  
  submenuButtons.forEach(button => {
    button.addEventListener('click', function() {
      const buttonId = this.id;
      const itemId = buttonId.replace('submenu-btn-', '');
      const submenu = document.getElementById('submenu-' + itemId);
      const icon = document.getElementById('submenu-icon-' + itemId);
      
      if (submenu) {
        submenu.classList.toggle('hidden');
        submenu.classList.toggle('flex');
      }
      
      if (icon) {
        icon.classList.toggle('rotate-180');
      }
    });
  });
  
  // Handle fallback submenu if exists
  const fallbackBtn = document.getElementById('submenu-btn-fallback');
  const fallbackSubmenu = document.getElementById('submenu-fallback');
  const fallbackIcon = document.getElementById('submenu-icon-fallback');
  
  if (fallbackBtn && fallbackSubmenu && fallbackIcon) {
    fallbackBtn.addEventListener('click', () => {
      fallbackSubmenu.classList.toggle('hidden');
      fallbackSubmenu.classList.toggle('flex');
      fallbackIcon.classList.toggle('rotate-180');
    });
  }
});
  