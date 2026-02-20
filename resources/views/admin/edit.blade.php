@extends('layouts.app')

@section('title', __('Edit Car'))

@section('content')
<div class="container my-5 text-white">
    <h2 class="mb-4">{{ __('Edit Car') }}</h2>
    
    <div class="card bg-dark text-white">
        <div class="card-body">
            <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.form')
                
                <div class="text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('Update Car') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection