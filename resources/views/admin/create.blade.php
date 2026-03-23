@extends('layouts.app')

@section('title', __('Add New Car'))

@section('content')
<div class="container text-white" style="margin-top: 6rem;">
    <h2 class="mb-4">{{ __('Add New Car') }}</h2>

    <div class="card bg-dark text-white">
        <div class="card-body">
            <form action="{{ route('admin.cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('admin.form')

                <div class="text-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    <button type="submit" class="btn btn-success">{{ __('Add Car') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection