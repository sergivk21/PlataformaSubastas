<nav class="bg-white shadow-sm" style="width:100vw;background:#f3f4f6;">
    <div style="width:100vw;display:flex;justify-content:center;align-items:center;padding:0.75rem 0 0.75rem 0;margin:0;background:#f3f4f6;">
        <!-- Botón menú hamburguesa -->
        <button id="menu-toggle" style="background: none; border: none; color: #64748b; font-size: 2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px;">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <!-- Menú desplegable -->
    <div id="mobile-menu" class="hidden px-4 pb-4" style="display:none;">
        <div class="flex flex-col space-y-2">
            <a href="{{ route('auctions.mobile.index') }}" style="color: #64748b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.2s ease; display: flex; align-items: center;">
                <i class="fas fa-gavel" style="margin-right: 0.5rem;"></i> Subastas
            </a>
            @auth
                <a href="{{ route('auctions.create') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s ease; display: flex; align-items: center;">
                    <i class="fas fa-plus" style="margin-right: 0.5rem;"></i> Crear Subasta
                </a>
                <a href="{{ route('profile.mobile.show') }}" style="color: #1e293b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; display: flex; align-items: center;">
                    <i class="fas fa-user" style="margin-right: 0.5rem; color: #2563eb;"></i> Perfil
                </a>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.mobile.dashboard') }}" style="color: #1e293b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; display: flex; align-items: center;">
                        <i class="fas fa-cogs" style="margin-right: 0.5rem; color: #2563eb;"></i> Panel Administración
                    </a>
                @endif
                <!--<form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" style="color: #1e293b; background: none; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; display: flex; align-items: center; width: 100%; text-align: left; cursor: pointer;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 0.5rem; color: #2563eb;"></i> Cerrar Sesión
                    </button>
                </form>-->
            @endauth
            @guest
                <a href="{{ route('login') }}" style="color: #64748b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; display: flex; align-items: center;">
                    <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; display: flex; align-items: center;">
                    <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i> Registrarse
                </a>
            @endguest
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            if(menuToggle && mobileMenu) {
              console.log('[DEBUG] menu-toggle y mobile-menu encontrados');
            } else {
              document.body.insertAdjacentHTML('beforeend', '<div style="position:fixed;bottom:0;left:0;width:100vw;background:#dc2626;color:white;padding:8px;font-size:14px;z-index:9999;">[ERROR] No se encontraron los IDs del menú móvil</div>');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    mobileMenu.classList.toggle('hidden');
                    // Alternar el display también
                    if (mobileMenu.classList.contains('hidden')) {
                      mobileMenu.style.display = 'none';
                    } else {
                      mobileMenu.style.display = 'block';
                    }
                });
                document.addEventListener('click', function(event) {
                    if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        mobileMenu.style.display = 'none';
                    }
                });
            }
        });
    </script>
</nav>
