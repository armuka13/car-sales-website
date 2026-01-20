@extends('layouts.app')

@section('title', 'Add New Car')

@section('content')
<div class="container my-5 text-white">
    <h2 class="mb-4">Add New Car</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.form')
                
                <div class="text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Add Car</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection