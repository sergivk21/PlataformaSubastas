<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Queue;
use App\Events\WorkerDown;
use Illuminate\Support\Facades\Event;

class WorkerStatusController extends Controller
{
    public function index()
    {
        // Verificar si el worker está activo
        $isActive = Cache::remember('worker_status', 60, function () {
            return Queue::size() > 0 || Queue::running();
        });

        // Verificar si el worker se ha detenido
        $wasActive = Cache::get('worker_status', false);
        if (!$isActive && $wasActive) {
            // El worker se ha detenido, disparar evento
            Event::dispatch(new WorkerDown());
        }

        // Obtener estadísticas
        $stats = [
            'queue_size' => Queue::size(),
            'pending_jobs' => Queue::size('default'),
            'last_checked' => now()->format('Y-m-d H:i:s'),
            'is_active' => $isActive
        ];

        // Guardar el estado en la caché
        Cache::put('worker_stats', $stats, now()->addMinutes(1));
        Cache::put('worker_status', $isActive, now()->addMinutes(1));

        return response()->json($stats);
    }

    public function ping()
    {
        // Actualizar el estado del worker
        Cache::put('worker_status', true, now()->addMinutes(1));
        return response()->json(['status' => 'ok']);
    }
}
