@extends('layouts.mobile.base')

@section('title', 'Crear Subasta')

@section('content')
<style>
    .mobile-auction-create-card {
        max-width: 430px;
        margin: 1.5rem auto 1.5rem auto;
        background: #fff;
        border-radius: 1.1rem;
        box-shadow: 0 2px 10px 0 rgba(31,38,135,0.13);
        padding: 1.6rem 1.1rem 1.3rem 1.1rem;
        box-sizing: border-box;
        width: 100%;
    }
    .mobile-auction-create-title {
        text-align: center;
        font-size: 1.12rem;
        font-weight: 800;
        color: #2563eb;
        margin-bottom: 1.1rem;
    }
    .mobile-auction-create-label {
        font-weight: 600;
        color: #2563eb;
        font-size: 0.98em;
        margin-bottom: 0.18em;
    }
    .mobile-auction-create-input, .mobile-auction-create-textarea {
        width: 100%;
        max-width: 100%;
        border-radius: 0.5em;
        border: 1px solid #cbd5e1;
        padding: 0.5em 0.9em;
        font-size: 1em;
        margin-bottom: 0.55em;
        box-shadow: 0 1px 3px rgba(31,38,135,0.06);
        box-sizing: border-box;
        display: block;
    }
    .mobile-auction-create-btn {
        background: #2563eb;
        color: #fff;
        border: none;
        border-radius: 0.5rem;
        padding: 0.7em 1.3em;
        font-size: 1em;
        font-weight: 700;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(31,38,135,0.09);
        transition: background 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.5em;
        margin-top: 0.2em;
    }
    .mobile-auction-create-btn:active, .mobile-auction-create-btn:focus {
        background: #1d4ed8;
    }
    .mobile-auction-create-back {
        margin-top: 1.2em;
        text-align: center;
    }
    .mobile-auction-create-back a {
        color: #64748b;
        text-decoration: underline;
        font-size: 0.96em;
        font-weight: 500;
        transition: color 0.2s;
    }
    .mobile-auction-create-back a:active {
        color: #2563eb;
    }
</style>
<div class="mobile-auction-create-card">
    <div class="mobile-auction-create-title">Crear Nueva Subasta</div>
    @if(session('success'))
        <div style="background:#d1fae5;color:#065f46;border-radius:0.6em;padding:0.7em 1em;margin-bottom:1em;text-align:center;font-size:0.99em;font-weight:500;box-shadow:0 1px 4px rgba(31,38,135,0.07);">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:0.6em;padding:0.7em 1em;margin-bottom:1em;text-align:center;font-size:0.99em;font-weight:500;box-shadow:0 1px 4px rgba(31,38,135,0.07);">
            <ul style="margin:0;padding:0;list-style:none;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fee2e2;color:#991b1b;border-radius:0.6em;padding:0.7em 1em;margin-bottom:1em;text-align:center;font-size:0.99em;font-weight:500;box-shadow:0 1px 4px rgba(31,38,135,0.07);">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('auctions.mobile.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="display:flex;flex-direction:column;gap:0.7em;">
            <div>
                <label for="title" class="mobile-auction-create-label">Título de la subasta</label>
                <input type="text" class="mobile-auction-create-input @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="image" class="mobile-auction-create-label">Imagen principal</label>
                <input type="file" class="mobile-auction-create-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                @error('image')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <small style="color:#64748b;display:block;margin-top:0.2em;font-size:0.93em;">
                    <i class="fas fa-info-circle me-1"></i>Formatos soportados: JPEG, PNG, GIF (máx. 2MB)
                </small>
            </div>
            <div>
                <label for="description" class="mobile-auction-create-label">Descripción</label>
                <textarea class="mobile-auction-create-textarea @error('description') is-invalid @enderror" id="description" name="description" rows="4" placeholder="Describe tu subasta..." required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div style="display:flex;flex-direction:column;gap:0.8em;">
                <div>
                    <label for="starting_price" class="mobile-auction-create-label">Precio inicial</label>
                    <input type="number" class="mobile-auction-create-input @error('starting_price') is-invalid @enderror" id="starting_price" name="starting_price" value="{{ old('starting_price') }}" step="0.01" min="0" required>
                    @error('starting_price')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="end_date" class="mobile-auction-create-label">Fecha y hora de cierre</label>
                    <input type="datetime-local" class="mobile-auction-create-input @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                    @error('end_date')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div style="text-align:center;margin-top:1.5em;">
            <button type="submit" class="mobile-auction-create-btn">
                <i class="fas fa-plus"></i> Crear Subasta
            </button>
            <div class="mobile-auction-create-back">
                <a href="{{ route('auctions.mobile.index') }}"><i class="fas fa-arrow-left me-1"></i> Volver al listado</a>
            </div>
        </div>
    </form>
</div>
@endsection
