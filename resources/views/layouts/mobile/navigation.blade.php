<nav class="bg-white shadow-sm" style="width:100vw;background:#f3f4f6;">
    <div style="width:100vw;display:flex;align-items:center;justify-content:space-between;padding:0.75rem 0 0.75rem 0;margin:0;background:#f3f4f6;">
        <!-- Espaciador para mantener el centro visual (ahora a la izquierda)-->
        <div style="width: 48px; height: 48px; margin-left: 8px;"></div>
        <!-- Logo y título CENTRADOS, enlace a home móvil dedicada -->
        <a href="{{ route('home.mobile') }}" style="display: flex; flex-direction: row; align-items: center; gap: 0.6rem; text-decoration: none; margin: 0 auto;">
            <span style="font-weight: 900; font-size: 2.45rem; letter-spacing: -2px; font-family: 'Poppins', 'Segoe UI', Arial, sans-serif; text-transform: uppercase; background: linear-gradient(90deg,#1e40af 0%, #2563eb 30%, #38bdf8 70%, #0ea5e9 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent; text-shadow: 0 2px 14px rgba(37,99,235,0.19); filter: none;">
                Subastas <span style="font-weight: 900; background: linear-gradient(90deg,#0ea5e9 0%, #38bdf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; color: transparent;">COELHO</span>
            </span>
        </a>
        <!-- Botón menú hamburguesa a la DERECHA -->
        <button id="menu-toggle" style="background: none; border: none; color: #64748b; font-size: 2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; width: 48px; height: 48px; margin-right: 8px;">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <!-- Menú desplegable -->
    <div id="mobile-menu" class="hidden px-4 pb-4" style="display:none;">
        <div class="flex flex-col space-y-2">
            <a href="{{ route('auctions.mobile.index') }}" class="mobile-menu-btn">
                <i class="fas fa-gavel"></i> Subastas
            </a>
            @auth
                <a href="{{ route('auctions.mobile.create') }}" class="mobile-menu-btn mobile-menu-btn-primary"
                   @if(!(auth()->user()->hasRole('seller') || auth()->user()->hasRole('admin'))) style="display:none" @endif>
                    <i class="fas fa-plus"></i> Crear Subasta
                </a>
                <a href="{{ route('profile.mobile.show') }}" class="mobile-menu-btn">
                    <i class="fas fa-user"></i> Perfil
                </a>
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('admin.mobile.dashboard') }}" class="mobile-menu-btn">
                        <i class="fas fa-cogs"></i> Panel Administración
                    </a>
                    <a href="{{ route('auctions.mobile.index') }}" class="mobile-menu-btn mobile-menu-btn-won">
                        <i class="fas fa-trophy"></i> Subastas ganadas
                    </a>
                @endif
            @endauth
            @guest
                <a href="{{ route('login') }}" class="mobile-menu-btn">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="mobile-menu-btn mobile-menu-btn-primary">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            @endguest
            <a href="{{ route('auctions.index') }}" class="mobile-menu-btn mobile-menu-btn-desktop">
                <i class="fas fa-desktop"></i> Cambiar a versión escritorio
            </a>
        </div>
    </div>
    <style>
        .mobile-menu-btn {
            color: #64748b;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 1.08em;
            gap: 0.5em;
            background: none;
            border: none;
            margin-bottom: 0.2em;
        }
        .mobile-menu-btn i { margin-right: 0.5em; }
        .mobile-menu-btn-primary {
            background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
            color: #fff !important;
        }
        .mobile-menu-btn-won {
            background: #fef08a;
            color: #92400e !important;
        }
        .mobile-menu-btn-desktop {
            background: #dbeafe;
            color: #2563eb !important;
        }
        .mobile-menu-btn:hover, .mobile-menu-btn:focus {
            background: #e0e7ef;
            color: #2563eb !important;
        }
    </style>
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
