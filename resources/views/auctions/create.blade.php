@extends('layouts.base')

@section('title', 'Crear Nueva Subasta')

@section('content')
<div class="container-fluid px-4 px-md-5" style="max-width: 1200px; margin-left: auto; margin-right: auto; padding: 0;">
    <div class="row justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">
            <div class="card shadow-lg border-0 rounded-3" style="max-width: 600px;">
                <div class="card-body p-5">
                    <!-- Mensajes de éxito -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Mensajes de error -->
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card-header bg-primary text-white py-4">
                        <h2 class="mb-0 text-center">Crear Nueva Subasta</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auctions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-heading text-primary"></i>
                                    </span>
                                    <input type="text" class="form-control border-0 shadow-sm @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" placeholder="Título de la subasta" required>
                                </div>
                                @error('title')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-image text-primary"></i>
                                    </span>
                                    <input type="file" class="form-control border-0 shadow-sm @error('image') is-invalid @enderror" 
                                           id="image" name="image" accept="image/*">
                                </div>
                                @error('image')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">
                                    <i class="fas fa-info-circle me-1"></i>Formatos soportados: JPEG, PNG, GIF (máx. 2MB)
                                </small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-align-left text-primary"></i>
                                    </span>
                                    <textarea class="form-control border-0 shadow-sm @error('description') is-invalid @enderror" 
                                              id="description" name="description" rows="4" placeholder="Describe tu subasta..." required>{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-euro-sign text-primary"></i>
                                    </span>
                                    <input type="number" class="form-control border-0 shadow-sm @error('starting_price') is-invalid @enderror" 
                                           id="starting_price" name="starting_price" value="{{ old('starting_price') }}" 
                                           step="0.01" min="0" placeholder="Precio inicial" required>
                                </div>
                                @error('starting_price')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">
                                        <i class="fas fa-calendar-alt text-primary"></i>
                                    </span>
                                    <input type="datetime-local" class="form-control border-0 shadow-sm @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                </div>
                                @error('end_date')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Subasta
                            </button>
                            <div class="mt-2">
                                <a href="{{ route('auctions.index') }}" class="text-decoration-none text-secondary">
                                    Cancelar
                                </a>
                            </div>
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
