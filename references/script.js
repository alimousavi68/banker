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

 const submenuBtn = document.getElementById('submenu-btn');
  const submenu = document.getElementById('submenu');
  const submenuIcon = document.getElementById('submenu-icon');

  submenuBtn.addEventListener('click', () => {
    submenu.classList.toggle('hidden'); // باز/بسته کردن زیرمنو
    submenuIcon.classList.toggle('rotate-180'); // چرخش آیکون
  });
  