@extends('layouts.app')

@section('title', __('Site Settings'))

@section('content')
<div class="container my-5 text-white">
    <h2 class="mb-4">{{ __('Site Settings') }}</h2>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <div class="card bg-dark text-white">
        <div class="card-body">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">{{ __('Site Name *') }}</label>
                    <input type="text" name="name" class="form-control bg-dark text-white @error('name') is-invalid @enderror" 
                           value="{{ old('name', $settings->name) }}" required>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">{{ __('Contact Email *') }}</label>
                    <input type="email" name="email" class="form-control bg-dark text-white @error('email') is-invalid @enderror" 
                           value="{{ old('email', $settings->email) }}">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">{{ __('Contact Phone *') }}</label>
                    <input type="text" name="phone" class="form-control bg-dark text-white @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $settings->phone) }}" required>
                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('WhatsApp Number *') }}</label>
                    <input type="text" name="whatsapp" class="form-control bg-dark text-white @error('whatsapp') is-invalid @enderror" 
                           value="{{ old('whatsapp', $settings->whatsapp) }}">
                    @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3">
                    <label class="form-label">{{ __('Image for First Page') }}</label>
                    <input type="file" name="image" class="form-control bg-dark text-white @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    @if(isset($settings) && $settings->image)
                        <div class="mt-2">
                            <small class="text-muted d-block mb-1">{{ __('Current image:') }}</small>
                            <img src="{{ asset('storage/' . $settings->image) }}" class="img-thumbnail" width="150">
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label class="form-label">{{ __('Page Description *') }}</label>
                    <input type="text" name="description" class="form-control bg-dark text-white @error('description') is-invalid @enderror" 
                           value="{{ old('description', $settings->description) }}" >
                    @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">{{ __('Update Settings') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection