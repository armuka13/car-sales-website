@extends('layouts.app')

@section('title', 'Edit Car')

@section('content')
<div class="container my-5 text-white">
    <h2 class="mb-4">Edit Car</h2>
    
    <div class="card">
        <div class="card-body" style="background-color:white;">
            <form action="{{ route('admin.cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('admin.form')
                
                <div class="text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Car</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection