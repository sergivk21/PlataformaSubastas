<nav class="bg-white shadow-sm">
    <div class="max-w-full mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span class="ml-2 font-bold text-gray-900">Subastas</span>
            </a>

            <button id="menu-toggle" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <div id="mobile-menu" class="hidden mt-4">
            <div class="space-y-2">
                <a href="{{ route('auctions.index') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded">
                    <i class="fas fa-gavel mr-2"></i> Subastas
                </a>
                @auth
                    <a href="{{ route('auctions.create') }}" class="flex items-center px-4 py-2 bg-blue-600 text-white rounded">
                        <i class="fas fa-plus mr-2"></i> Crear Subasta
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

                    <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                        <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease;">
                            <i class="fas fa-user" style="color: #2563eb;"></i> Perfil
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease;">
                            <i class="fas fa-cog" style="color: #2563eb;"></i> Panel de Administración
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease; width: 100%;">
                                <i class="fas fa-sign-out-alt" style="color: #2563eb;"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @endauth

                @guest
                    <a href="{{ route('login') }}" style="display: flex; align-items: center; padding: 0.75rem 1rem; color: #64748b; text-decoration: none; gap: 0.5rem; transition: all 0.2s ease;">
                        <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i> Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" style="background-color: #2563eb; color: white; padding: 0.75rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s ease;">
                        <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i> Registrarse
                    </a>
                @endguest
            </div>
        </div>
    </div>
</nav>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    menuToggle.onclick = function() {
        mobileMenu.style.display = mobileMenu.style.display === 'block' ? 'none' : 'block';
    };

    // Cerrar el menú cuando se hace clic fuera
    document.addEventListener('click', function(event) {
        if (!menuToggle.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.style.display = 'none';
        }
    });
</script>
