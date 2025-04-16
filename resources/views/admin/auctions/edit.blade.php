@extends('layouts.base')

@section('title', 'Editar Subasta')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Subasta</h1>
        <a href="{{ route('admin.auctions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.auctions.update', $auction) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label">Nombre</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $auction->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Descripción</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description', $auction->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="starting_price" class="form-label">Precio Inicial</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" min="0" class="form-control @error('starting_price') is-invalid @enderror" id="starting_price" name="starting_price" value="{{ old('starting_price', $auction->starting_price) }}" required>
                    </div>
                    @error('starting_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ends_at" class="form-label">Fecha de Finalización</label>
                    <input type="datetime-local" class="form-control @error('ends_at') is-invalid @enderror" id="ends_at" name="ends_at" value="{{ old('ends_at', $auction->ends_at->format('Y-m-d\TH:i')) }}" required>
                    @error('ends_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Estado</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="pending" {{ old('status', $auction->status) === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="active" {{ old('status', $auction->status) === 'active' ? 'selected' : '' }}>Activa</option>
                        <option value="finished" {{ old('status', $auction->status) === 'finished' ? 'selected' : '' }}>Finalizada</option>
                        <option value="cancelled" {{ old('status', $auction->status) === 'cancelled' ? 'selected' : '' }}>Cancelada</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
