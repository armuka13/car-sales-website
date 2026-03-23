@forelse($cars as $car)
<div class="col-6 col-md-4 car-item" data-brand="{{ strtolower($car->brand) }}"
    data-model="{{ strtolower($car->model) }}" data-category="{{ strtolower($car->category) }}"
    data-condition="{{ $car->condition }}" data-fuel="{{ $car->fuel_type }}" data-year="{{ $car->year }}"
    data-mileage="{{ $car->mileage ?? 0 }}" data-price="{{ $car->price }}">
    <div class="card car-card h-100">
        @guest
        <button class="toggle-favorite" data-car-id="{{ $car->id }}">
            <i class="fas fa-heart"></i>
        </button>
        @endguest
        <div class="card-img-wrapper">
            @if($car->image)
            <img src="{{ Str::startsWith($car->image, 'http') ? $car->image : asset('storage/' . $car->image) }}"
                class="card-img-top car-image" alt="{{ $car->brand }} {{ $car->model }}">
            @else
            <div class="car-image bg-secondary d-flex align-items-center justify-content-center"
                style="background: linear-gradient(135deg, #2a2f38, #1e2329);">
                <i class="fas fa-car fa-4x" style="color: rgba(255,255,255,0.15);"></i>
            </div>
            @endif
            <div class="car-image-overlay">
                <span class="text-white fw-semibold" style="font-size: 0.85rem; opacity: 0.9;">
                    <i class="fas fa-eye me-1"></i>{{ __('View Details') }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <h5 class="card-title text-light fw-semibold mb-1" style="font-size: 0.95rem;">{{ $car->brand }} {{
                $car->model }}</h5>
            <p class="price-tag mb-2">{{ number_format($car->price, 0) }} €</p>

            <div class="d-flex flex-wrap gap-1 mb-2">
                <span class="badge badge-premium"><i class="fas fa-check-circle me-1" style="font-size: 0.6rem;"></i>{{
                    ucfirst($car->condition) }}</span>
                <span class="badge badge-premium"><i class="fas fa-calendar-alt me-1" style="font-size: 0.6rem;"></i>{{
                    $car->year }}</span>
                <span class="badge badge-premium"><i class="fas fa-cogs me-1" style="font-size: 0.6rem;"></i>{{
                    ucfirst($car->transmission) }}</span>
            </div>

            <p class="card-text small mb-3" style="color: rgba(255,255,255,0.5);">
                <i class="fas fa-gas-pump me-1" style="color: #78e518;"></i>
                <span class="text-white">{{ ucfirst($car->fuel_type) }}</span>
                @if(isset($car->mileage))
                <span class="mx-1">·</span>
                <i class="fas fa-tachometer-alt me-1" style="color: #78e518;"></i>{{ number_format($car->mileage) }} km
                @endif
            </p>

            <a href="{{ route('cars.show', $car->id) }}" class="btn btn-detail w-100">
                {{ __('View Details') }} <i class="fas fa-arrow-right ms-1 btn-arrow"></i>
            </a>
        </div>
    </div>
</div>
@empty
<div class="col-12">
    <div class="text-center py-5"
        style="background: rgba(30, 35, 42, 0.5); border-radius: 18px; border: 1px solid rgba(255,255,255,0.06);">
        <i class="fas fa-car fa-3x mb-3" style="color: rgba(255,255,255,0.15);"></i>
        <p class="text-white mb-0">{{ __('No cars available at the moment.') }}</p>
    </div>
</div>
@endforelse

<style>
    .btn-detail {
        background: rgba(120, 229, 24, 0.1);
        color: #78e518;
        border: 1px solid rgba(120, 229, 24, 0.2);
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-detail:hover {
        background: linear-gradient(135deg, #5cb510, #3d8a08);
        color: white;
        border-color: transparent;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(92, 181, 16, 0.3);
    }

    .btn-detail .btn-arrow {
        transition: transform 0.3s ease;
        font-size: 0.75rem;
    }

    .btn-detail:hover .btn-arrow {
        transform: translateX(4px);
    }
</style>