document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.nav__toggle');
    const isMobile = () => window.innerWidth < 768;
  
    if (toggles.length === 0) return;
  
    toggles.forEach(toggle => {
      const item = toggle.closest('.nav__item');
      if (!item) return;
  
      toggle.addEventListener('click', e => {
        const dropdown = item.querySelector('.nav__dropdown');
  
        if (dropdown) {
          e.preventDefault();
  
          // Cerrar otros
          document.querySelectorAll('.nav__item').forEach(el => {
            if (el !== item) el.classList.remove('active');
          });
  
          // Toggle actual
          item.classList.toggle('active');
        }
      });
  
      // Cerrar si haces clic fuera
      document.addEventListener('click', e => {
        if (!item.contains(e.target)) {
          item.classList.remove('active');
        }
      });
  
      // Cerrar en móvil cuando se hace clic en un enlace del submenú
      const links = item.querySelectorAll('.nav__dropdown a');
      links.forEach(link => {
        link.addEventListener('click', () => {
          if (isMobile()) {
            item.classList.remove('active');
          }
        });
      });
    });
});  