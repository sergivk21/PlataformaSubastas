<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MobileDetection
{
    public function handle(Request $request, Closure $next)
    {
        // Verificar si es un dispositivo móvil usando diferentes métodos
        $userAgent = $request->header('User-Agent');
        $isMobile = 
            // Verificar User-Agent
            (strpos($userAgent, 'Mobi') !== false) || 
            (strpos($userAgent, 'Android') !== false) || 
            (strpos($userAgent, 'iPhone') !== false) || 
            (strpos($userAgent, 'iPad') !== false) || 
            (strpos($userAgent, 'iPod') !== false) || 
            // Verificar ancho de pantalla
            ($request->header('Sec-Ch-Ua-Mobile') === '?1') || 
            // Verificar dispositivo móvil
            (strpos($userAgent, 'Windows Phone') !== false);

        // Si es móvil y no estamos en la vista móvil
        if ($isMobile && !$request->is('mobile/*')) {
            // Redirigir a la versión móvil
            $currentPath = $request->path();
            if (strpos($currentPath, 'auctions/') === 0) {
                $mobilePath = str_replace('auctions/', 'mobile/auctions/', $currentPath);
                return Redirect::to($mobilePath);
            }
        }

        return $next($request);
    }
}
