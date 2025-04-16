document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });

        // Cerrar el menú al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    }
});
