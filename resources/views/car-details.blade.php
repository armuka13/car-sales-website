@extends('layouts.app')
@section('title', $car->brand . ' ' . $car->model . ' - ' . $settings->name)

@section('content')
<div class="contact-bar">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6">
                <i class="fas fa-envelope"></i> Email: <strong>{{ $settings->email }}</strong>
            </div>
            <div class="col-md-6">
                <i class="fas fa-phone"></i> Phone: <strong>{{ $settings->phone }}</strong>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">


    <!-- Car Details Card -->
    <div class="card bg-dark text-light border-0 shadow-lg">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Image Carousel Section -->
                <div class="col-lg-7">
                    @php
                        $allImages = [];
                        if ($car->image) {
                            $allImages[] = $car->image;
                        }
                        if ($car->images && count($car->images) > 0) {
                            $allImages = array_merge($allImages, $car->images);
                        }
                    @endphp

                    @if(count($allImages) > 0)
                        <div id="carImageCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($allImages as $index => $image)
                                    <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="{{ $index }}" 
                                        class="{{ $index === 0 ? 'active' : '' }}" 
                                        aria-current="{{ $index === 0 ? 'true' : 'false' }}" 
                                        aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded-start">
                                @foreach($allImages as $index => $image)
                                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                        <img src="{{ Str::startsWith($image, 'http') ? $image : asset('storage/' . $image) }}"
                                             class="d-block w-100 car-detail-image" 
                                             alt="{{ $car->brand }} {{ $car->model }} - Image {{ $index + 1 }}"
                                             style="max-height: 600px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                            @if(count($allImages) > 1)
                                <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            @endif
                        </div>
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded-start" style="height: 600px;">
                            <i class="fas fa-car fa-5x text-white"></i>
                        </div>
                    @endif
                </div>

                <!-- Details Section -->
                <div class="col-lg-5">
                    <div class="p-4 p-lg-5">
                        <!-- Title and Price -->
                        <h1 class="display-5 mb-3">{{ $car->brand }} {{ $car->model }}</h1>
                        <h2 class="price-tag mb-4" style="font-size: 2.5rem;">${{ number_format($car->price, 0) }}</h2>

                        <!-- Primary Badges -->
                        <div class="mb-4">
                            <span class="badge bg-primary badge-custom me-2 mb-2" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                {{ ucfirst($car->condition) }}
                            </span>
                            <span class="badge bg-info badge-custom me-2 mb-2" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                {{ $car->year }}
                            </span>
                            <span class="badge bg-warning text-dark badge-custom me-2 mb-2" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                {{ ucfirst($car->transmission) }}
                            </span>
                            <span class="badge bg-success badge-custom me-2 mb-2" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                {{ ucfirst($car->fuel_type) }}
                            </span>
                            @if($car->category)
                                <span class="badge bg-danger badge-custom me-2 mb-2" style="font-size: 1rem; padding: 0.5rem 1rem;">
                                    {{ $car->category }}
                                </span>
                            @endif
                        </div>

                        <!-- Specifications Grid -->
                        <div class="specifications-grid mb-4">
                            <h5 class="mb-3 text-uppercase" style="letter-spacing: 1px; color: #ffc107;">
                                <i class="fas fa-cog me-2"></i>Specifications
                            </h5>
                            
                            <div class="row g-3">
                                @if($car->mileage!==null)
                                    <div class="col-6">
                                        <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                            <i class="fas fa-tachometer-alt text-warning mb-2"></i>
                                            <div class="small text-white">Mileage</div>
                                            <div class="fw-bold">{{ number_format($car->mileage) }} km</div>
                                        </div>
                                    </div>
                                @endif

                                @if($car->performance)
                                    <div class="col-6">
                                        <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                            <i class="fas fa-bolt text-danger mb-2"></i>
                                            <div class="small text-white">Power</div>
                                            <div class="fw-bold">{{ $car->performance }} kW ({{ ceil($car->performance * 1.34) }} HP)</div>
                                        </div>
                                    </div>
                                @endif

                                @if($car->consumption)
                                    <div class="col-6">
                                        <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                            <i class="fas fa-gas-pump text-info mb-2"></i>
                                            <div class="small text-white">Consumption</div>
                                            <div class="fw-bold">{{ $car->consumption }} l/100km</div>
                                        </div>
                                    </div>
                                @endif

                                @if($car->number_of_seats)
                                    <div class="col-6">
                                        <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                            <i class="fas fa-users text-primary mb-2"></i>
                                            <div class="small text-white">Seats</div>
                                            <div class="fw-bold">{{ $car->number_of_seats }} Seats</div>
                                        </div>
                                    </div>
                                @endif

                                @if($car->color)
                                    <div class="col-6">
                                        <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                            <i class="fas fa-palette text-success mb-2"></i>
                                            <div class="small text-white">Color</div>
                                            <div class="fw-bold">{{ ucfirst($car->color) }}</div>
                                        </div>
                                    </div>
                                @endif

                           

                                <div class="col-6">
                                    <div class="spec-item p-3 bg-secondary bg-opacity-25 rounded">
                                        <i class="fas fa-calendar text-warning mb-2"></i>
                                        <div class="small text-white">Year</div>
                                        <div class="fw-bold">{{ $car->year }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact CTA -->
                        <div class="contact-cta p-4 bg-gradient rounded mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <h5 class="mb-3">
                                <i class="fas fa-handshake me-2"></i>Interested in this car?
                            </h5>
                            <p class="mb-2">
                                <p class="text-white text-decoration-none">
                                    <strong>Car ID: </strong>{{ str_pad($car->id, 6, '0', STR_PAD_LEFT) }}
                                </p>
                            </p>
                            <p class="mb-2">
                                <i class="fas fa-envelope me-2"></i>
                                <a href="mailto:{{ $settings->email }}" class="text-white text-decoration-none">
                                    {{ $settings->email }}
                                </a>
                            </p>
                            <p class="mb-0">
                                <i class="fas fa-phone me-2"></i>
                                <a href="tel:{{ $settings->phone }}" class="text-white text-decoration-none">
                                    {{ $settings->phone }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            @if($car->description)
                <div class="p-4 p-lg-5 border-top border-secondary">
                    <h4 class="mb-3 text-uppercase" style="letter-spacing: 1px; color: #ffc107;">
                        <i class="fas fa-info-circle me-2"></i>Description
                    </h4>
                    <p class="lead" style="line-height: 1.8;">{{ $car->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Additional Actions -->
    <div class="mt-4 text-center">
        <a href="{{ route('home') }}" class="btn btn-lg btn-outline-light px-5">
            <i class="fas fa-arrow-left me-2"></i>View More Cars
        </a>
    </div>
</div>

<style>
    .car-detail-image {
        transition: transform 0.3s ease;
    }

    .carousel-item:hover .car-detail-image {
        transform: scale(1.02);
    }

    .spec-item {
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .spec-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-color: rgba(255, 193, 7, 0.5);
    }

    .spec-item i {
        font-size: 1.5rem;
    }

    .contact-cta {
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        transition: transform 0.3s ease;
    }

    .contact-cta:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
    }

    .badge-custom {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .price-tag {
        color: #ffc107;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 991px) {
        .car-detail-image {
            max-height: 400px !important;
        }
    }
</style>
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carId = {{ $car->id }};
        let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
        
        // Remove if already exists to move to front
        recentlyViewed = recentlyViewed.filter(id => id !== carId);
        
        // Add to front
        recentlyViewed.unshift(carId);
        
        // Keep only top 10
        recentlyViewed = recentlyViewed.slice(0, 10);
        
        localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));
    });
</script>
@endsection
@endsection
