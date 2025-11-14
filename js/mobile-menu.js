/**
 * NetflixX - Menu Mobile
 * JavaScript pour le menu hamburger responsive
 */

function toggleMenu() {
    const navLinks = document.getElementById('navLinks');
    const burgerMenu = document.querySelector('.burger-menu');
    
    navLinks.classList.toggle('active');
    burgerMenu.classList.toggle('active');
}

// Fermer le menu si on clique ailleurs
document.addEventListener('click', function(e) {
    const navLinks = document.getElementById('navLinks');
    const burgerMenu = document.querySelector('.burger-menu');
    
    if (!burgerMenu.contains(e.target) && !navLinks.contains(e.target)) {
        navLinks.classList.remove('active');
        burgerMenu.classList.remove('active');
    }
});