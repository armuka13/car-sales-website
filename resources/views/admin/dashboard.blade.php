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
    
    <div class="card bg-dark text-white">
        <div class="card-body">
            <table class="table table-dark table-hover text-white">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Brand</th>
                        <th>ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr>
                        <td>
                            @if($car->image)
                                <img src="{{ Str::startsWith($car->image, 'http') ? $car->image : asset('storage/' . $car->image) }}" width="60" height="60" style="object-fit: cover;">
                            @else
                                <div style="width: 60px; height: 60px;" class="bg-secondary d-flex align-items-center justify-content-center">
                                    <i class="fas fa-car text-white"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ $car->brand }}</td>
                        <td>{{ str_pad($car->id, 6, '0', STR_PAD_LEFT) }}</td>
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
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content bg-dark text-white">
            <div class="modal-header border-secondary">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this car? This action cannot be undone.
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete Car</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    let deleteCarId = null;

    $('.delete-btn').on('click', function() {
        deleteCarId = $(this).data('id');
        $('#deleteModal').modal('show');
    });

    $('#confirmDelete').on('click', function() {
        if (deleteCarId) {
            $('#delete-form-' + deleteCarId).submit();
        }
    });
});
</script>
@endsection