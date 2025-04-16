<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;

trait MobileLayout
{
    protected function getLayout(Request $request)
    {
        // Si es una vista móvil, usar el layout móvil
        if ($request->is('mobile/*')) {
            return 'layouts.mobile.base';
        }
        
        // Si es un dispositivo móvil, usar el layout móvil
        $isMobile = $request->header('User-Agent') && 
                    (strpos($request->header('User-Agent'), 'Mobile') !== false || 
                     strpos($request->header('User-Agent'), 'Android') !== false || 
                     strpos($request->header('User-Agent'), 'iPhone') !== false);

        if ($isMobile) {
            return 'layouts.mobile.base';
        }

        // Por defecto, usar el layout base
        return 'layouts.base';
    }
}
