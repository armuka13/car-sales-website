@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5 text-white">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Admin Dashboard</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.cars.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Car
            </a>
        </div>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Condition</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr>
                        <td>
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" width="60" height="60" style="object-fit: cover;">
                            @else
                                <div style="width: 60px; height: 60px;" class="bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $car->brand }}</td>
                        <td>{{ $car->model }}</td>
                        <td>{{ $car->year }}</td>
                        <td>${{ number_format($car->price, 0) }}</td>
                        <td><span class="badge bg-primary">{{ ucfirst($car->condition) }}</span></td>
                        <td>
                            <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $car->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                            <form id="delete-form-{{ $car->id }}" action="{{ route('admin.cars.destroy', $car) }}" method="POST" class="d-none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No cars found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.delete-btn').on('click', function() {
        if (confirm('Are you sure you want to delete this car?')) {
            const id = $(this).data('id');
            $('#delete-form-' + id).submit();
        }
    });
});
</script>
@endsection