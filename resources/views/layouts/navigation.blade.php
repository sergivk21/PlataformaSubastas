<nav style="background-color: white; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); padding: 1rem;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem; display: flex; align-items: center; justify-content: space-between;">
        <!-- Logo y título -->
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <a href="{{ route('home') }}" style="display: flex; align-items: center;">
                <svg style="height: 1.5rem; width: 1.5rem;" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                <span style="font-size: 1.25rem; font-weight: 700; color: #1e293b;">Subastas</span>
            </a>
        </div>

        <!-- Menú de navegación -->
        <div style="display: flex; gap: 1rem; align-items: center;">
            <a href="{{ route('auctions.index') }}" style="color: #64748b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.2s ease;">
                <i class="fas fa-gavel" style="margin-right: 0.5rem;"></i> Subastas
            </a>
            @auth
                <a href="{{ route('auctions.create') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s ease;">
                    <i class="fas fa-plus" style="margin-right: 0.5rem;"></i> Crear Subasta
                </a>
            @endauth
        </div>

        <!-- Menú de usuario -->
        <div style="display: flex; gap: 1rem; align-items: center;">
            @auth
                <div style="position: relative; display: inline-block; z-index: 1000;">
                    <button type="button" style="display: flex; align-items: center; background: none; border: none; cursor: pointer;" onclick="toggleUserMenu()">
                        @php
                            $user = Auth::user();
                            $profilePhoto = $user->profile_photo ? asset('storage/' . $user->profile_photo) : null;
                            $photoExists = $user->profile_photo && file_exists(public_path('storage/' . $user->profile_photo));
                        @endphp
                        @if($photoExists)
                            <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto de perfil" style="height: 2rem; width: 2rem; border-radius: 50%; object-fit: cover; border: 2px solid #2563eb; background: #fff;" />
                        @else
                            <span style="display: inline-flex; align-items: center; justify-content: center; height: 2rem; width: 2rem; border-radius: 50%; background-color: #e0e7ff; color: #2563eb;">
                                <span style="font-size: 1.25rem;">{{ $user->name[0] }}</span>
                            </span>
                        @endif
                        <span style="margin-left: 0.5rem; color: #1e293b;">{{ $user->name }}</span>
                        <svg style="margin-left: 0.5rem; margin-right: -0.125rem; height: 1.25rem; width: 1.25rem; color: #94a3b8;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="user-menu" style="display: none; position: absolute; background-color: white; min-width: 200px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1); border-radius: 0.5rem; z-index: 1000; top: 100%; right: 0; margin-top: 0.5rem;">
                        <a href="{{ route('profile.show') }}" style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease;">
                            <i class="fas fa-user" style="color: #2563eb;"></i> Perfil
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                        <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease;">
                            <i class="fas fa-cog" style="color: #2563eb;"></i> Panel de Administración
                        </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display: flex; align-items: center; padding: 0.75rem 1.5rem; color: #1e293b; text-decoration: none; gap: 0.5rem; transition: background-color 0.2s ease;">
                                <i class="fas fa-sign-out-alt" style="color: #2563eb;"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}" style="color: #64748b; text-decoration: none; padding: 0.5rem 1rem; border-radius: 0.5rem; transition: all 0.2s ease;">
                    <i class="fas fa-sign-in-alt" style="margin-right: 0.5rem;"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" style="background-color: #2563eb; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; transition: all 0.2s ease;">
                    <i class="fas fa-user-plus" style="margin-right: 0.5rem;"></i> Registrarse
                </a>
            @endguest
        </div>
    </div>
</nav>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
    }

    // Cerrar el menú cuando se hace clic fuera
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('user-menu');
        const button = event.target.closest('button[onclick="toggleUserMenu()"]');
        
        if (!button && menu.style.display === 'block') {
            menu.style.display = 'none';
        }
    });
</script>
