/**
 * Nuevo script para el navbar responsive con mejoras de accesibilidad
 */
document.addEventListener('DOMContentLoaded', function() {
  // Elementos del navbar
  const navbarToggle = document.querySelector('.fiscal-navbar-toggle');
  const navbarNav = document.querySelector('.fiscal-navbar-nav');
  
  // Toggle para el menú móvil
  if (navbarToggle && navbarNav) {
    navbarToggle.addEventListener('click', function() {
      const isExpanded = navbarNav.classList.contains('show');
      navbarNav.classList.toggle('show');
      
      // Cambiar el ícono del botón toggle
      const toggleIcon = navbarToggle.querySelector('i');
      if (toggleIcon) {
        if (!isExpanded) {
          toggleIcon.classList.remove('fa-bars');
          toggleIcon.classList.add('fa-times');
          navbarToggle.setAttribute('aria-expanded', 'true');
        } else {
          toggleIcon.classList.remove('fa-times');
          toggleIcon.classList.add('fa-bars');
          navbarToggle.setAttribute('aria-expanded', 'false');
        }
      }
    });
  }
  
  // Cerrar el menú al hacer clic en un enlace (en móvil)
  const navLinks = document.querySelectorAll('.fiscal-navbar-link');
  navLinks.forEach(link => {
    link.addEventListener('click', function() {
      if (window.innerWidth < 992) {
        navbarNav.classList.remove('show');
        
        // Restaurar el ícono del botón toggle
        const toggleIcon = navbarToggle.querySelector('i');
        if (toggleIcon) {
          toggleIcon.classList.remove('fa-times');
          toggleIcon.classList.add('fa-bars');
          navbarToggle.setAttribute('aria-expanded', 'false');
        }
      }
    });
  });
  
  // Soporte para navegación con teclado
  navbarToggle.addEventListener('keydown', function(e) {
    // Activar con Enter o Space
    if (e.key === 'Enter' || e.key === ' ') {
      e.preventDefault();
      navbarToggle.click();
    }
  });
  
  // Cerrar el menú con Escape
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && navbarNav.classList.contains('show')) {
      navbarNav.classList.remove('show');
      const toggleIcon = navbarToggle.querySelector('i');
      if (toggleIcon) {
        toggleIcon.classList.remove('fa-times');
        toggleIcon.classList.add('fa-bars');
      }
      navbarToggle.setAttribute('aria-expanded', 'false');
      navbarToggle.focus();
    }
  });
  
  // Marcar el enlace activo según la URL actual
  const currentLocation = window.location.pathname;
  const navbarLinks = document.querySelectorAll('.fiscal-navbar-link');
  
  // Función para actualizar el enlace activo
  function updateActiveLink() {
    // Primero eliminar la clase active de todos los enlaces
    navbarLinks.forEach(link => {
      link.classList.remove('active');
      link.removeAttribute('aria-current');
    });
    
    // Luego marcar el enlace activo
    navbarLinks.forEach(link => {
      const linkPath = link.getAttribute('href');
      if (currentLocation.includes(linkPath) || 
          (currentLocation === '/' && linkPath === 'index.html')) {
        link.classList.add('active');
        link.setAttribute('aria-current', 'page');
      }
    });
  }
  
  // Ejecutar al cargar la página
  updateActiveLink();
  
  // Manejar clics en enlaces para actualizar el estado activo
  navbarLinks.forEach(link => {
    link.addEventListener('click', function() {
      navbarLinks.forEach(l => {
        l.classList.remove('active');
        l.removeAttribute('aria-current');
      });
      
      this.classList.add('active');
      this.setAttribute('aria-current', 'page');
    });
  });
  
  // Cerrar el menú al hacer clic fuera de él
  document.addEventListener('click', function(e) {
    if (window.innerWidth < 992 && 
        navbarNav.classList.contains('show') && 
        !navbarNav.contains(e.target) && 
        !navbarToggle.contains(e.target)) {
      
      navbarNav.classList.remove('show');
      const toggleIcon = navbarToggle.querySelector('i');
      if (toggleIcon) {
        toggleIcon.classList.remove('fa-times');
        toggleIcon.classList.add('fa-bars');
      }
      navbarToggle.setAttribute('aria-expanded', 'false');
    }
  });
});