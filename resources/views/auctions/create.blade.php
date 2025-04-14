@extends('layouts.app')

@section('title', 'Crear Nueva Subasta')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Crear Nueva Subasta</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('auctions.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="form-label">Título</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="starting_price" class="form-label">Precio Inicial (€)</label>
                            <input type="number" class="form-control @error('starting_price') is-invalid @enderror" 
                                   id="starting_price" name="starting_price" value="{{ old('starting_price') }}" 
                                   step="0.01" min="0" required>
                            @error('starting_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="form-label">Fecha de Finalización</label>
                            <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Crear Subasta</button>
                            <a href="{{ route('auctions.index') }}" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Establecer la fecha mínima como la fecha actual
    const endDateInput = document.getElementById('end_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    endDateInput.min = now.toISOString().slice(0, 16);
</script>
@endpush
@endsection
