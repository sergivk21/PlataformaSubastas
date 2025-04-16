@extends('layouts.base')

@section('title', 'Reportes')

@section('content')
<div class="container">
    <h1 class="mb-4">Reportes</h1>

    <div class="row">
        <!-- Reporte de ingresos -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ingresos Diarios</h5>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Reporte de subastas por estado -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Subastas por Estado</h5>
                </div>
                <div class="card-body">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Configuración del gráfico de ingresos
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: @json($revenue->pluck('date')->toArray()),
            datasets: [{
                label: 'Ingresos Totales',
                data: @json($revenue->pluck('total_revenue')->toArray()),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Configuración del gráfico de subastas por estado
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json(array_keys($auctionsByStatus)),
            datasets: [{
                data: @json(array_values($auctionsByStatus)),
                backgroundColor: [
                    'rgb(54, 162, 235)',
                    'rgb(255, 99, 132)',
                    'rgb(75, 192, 192)',
                    'rgb(255, 205, 86)',
                    'rgb(153, 102, 255)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
</script>
@endpush
@endsection
