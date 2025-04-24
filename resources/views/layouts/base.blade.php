<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fuentes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <!-- Estilos CSS -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body class="antialiased">
    <div style="min-height: 100vh; display: flex; flex-direction: column;">
        <div style="flex: 1 0 auto;">
            @include('layouts.navigation')
            
            @yield('content')
        </div>
        <footer style="margin-top: auto; background-color: white; border-top: 1px solid #e5e7eb;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0.5rem 1rem;">
                <p style="text-align: center; color: #4b5563;">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos los derechos reservados.</p>
            </div>
        </footer>
    </div>
    <script src="/js/app.js" defer></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const label = document.querySelector('label[for="profile_photo"]');
            const input = document.getElementById('profile_photo');
            const fileNameSpan = document.getElementById('selected-file-name');
            let previewImg = document.getElementById('profile-photo-preview');
            console.log('JS cargado, previewImg:', previewImg);

            if(label && input) {
                input.addEventListener('change', function(e) {
                    if (input.files && input.files[0]) {
                        fileNameSpan.textContent = input.files[0].name;
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg = document.getElementById('profile-photo-preview');
                            console.log('Preview encontrado:', previewImg, 'Tag:', previewImg && previewImg.tagName);
                            if(previewImg && previewImg.tagName === 'IMG') {
                                previewImg.src = e.target.result;
                                console.log('Imagen actualizada');
                            } else if (previewImg && previewImg.tagName === 'DIV') {
                                // Reemplaza el div por una imagen real para la previsualización
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.alt = 'Previsualización de foto';
                                img.id = 'profile-photo-preview';
                                img.style.width = '92px';
                                img.style.height = '92px';
                                img.style.borderRadius = '50%';
                                img.style.objectFit = 'cover';
                                img.style.border = '3px solid #22c55e';
                                img.style.boxShadow = '0 2px 14px 0 rgba(34,197,94,0.13)';
                                previewImg.parentNode.replaceChild(img, previewImg);
                                console.log('Div reemplazado por imagen');
                            } else {
                                console.log('No se encontró previewImg');
                            }
                        };
                        reader.readAsDataURL(input.files[0]);
                    } else {
                        fileNameSpan.textContent = '';
                    }
                });
            } else {
                console.log('No se encontró el label o el input de foto');
            }
        });
    </script>
</body>
</html>
