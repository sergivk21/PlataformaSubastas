<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\MobileLayout;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, MobileLayout;

    public function __construct()
    {
        // Establecer el layout para todas las vistas
        if (method_exists($this, 'getLayout')) {
            view()->share('layout', $this->getLayout(request()));
        }
    }
}
