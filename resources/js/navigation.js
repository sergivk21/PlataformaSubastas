document.addEventListener('DOMContentLoaded', function() {
    // Menú de usuario en dispositivos móviles
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = userMenuButton?.nextElementSibling;

    if (userMenuButton && userMenu) {
        // Abrir menú al hacer clic en dispositivos móviles
        userMenuButton.addEventListener('click', function(e) {
            e.preventDefault();
            if (window.innerWidth < 640) {
                userMenu.classList.toggle('hidden');
            }
        });

        // Cerrar menú al hacer clic en enlaces dentro del menú
        userMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 640) {
                    userMenu.classList.add('hidden');
                }
            });
        });
    }
});
