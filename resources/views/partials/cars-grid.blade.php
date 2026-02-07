@forelse($cars as $car)
<div class="col-6 col-md-4 car-item" 
     data-brand="{{ strtolower($car->brand) }}" 
     data-model="{{ strtolower($car->model) }}"
     data-category="{{ strtolower($car->category) }}"
     data-condition="{{ $car->condition }}"
     data-fuel="{{ $car->fuel_type }}"
     data-year="{{ $car->year }}"
     data-mileage="{{ $car->mileage ?? 0 }}"
     data-price="{{ $car->price }}">
    <div class="card car-card bg-dark">
        @guest
        <button class="toggle-favorite" data-car-id="{{ $car->id }}">
            <i class="fas fa-heart"></i>
        </button>   
        @endguest                
        @if($car->image)
            <img src="{{ Str::startsWith($car->image, 'http') ? $car->image : asset('storage/' . $car->image) }}" class="card-img-top car-image" alt="{{ $car->brand }} {{ $car->model }}">
        @else
            <div class="car-image bg-secondary d-flex align-items-center justify-content-center">
                <i class="fas fa-car fa-5x text-white"></i>
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title text-light">{{ $car->brand }} {{ $car->model }}</h5>
            <p class="price-tag mb-2">${{ number_format($car->price, 0) }}</p>
            
            <div class="mb-2">
                <span class="badge badge-premium">{{ ucfirst($car->condition) }}</span>
                <span class="badge badge-premium">{{ $car->year }}</span>
                <span class="badge badge-premium">{{ ucfirst($car->transmission) }}</span>
            </div>
            
            <p class="card-text text-muted small">
                <span class="text-white">
                    <i class="fas fa-gas-pump text-white"></i> {{ ucfirst($car->fuel_type) }}
                </span>
                @if(isset($car->mileage))
                    | <i class="fas fa-tachometer-alt"></i> {{ number_format($car->mileage) }} km
                @endif
            </p>
            
            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-primary w-100">
                View Details
            </a>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="alert alert-info text-center">
        <i class="fas fa-info-circle"></i> No cars available at the moment.
    </div>
</div>
@endforelse
