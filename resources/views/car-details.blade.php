@extends('layouts.app')
@section('title', $car->brand . ' ' . $car->model . ' - ' . $settings->name)

@section('content')
<div style="padding-top: 70px;"></div>

<div class="container my-5">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4 fade-in-up">
        <ol class="breadcrumb" style="background: transparent; padding: 0; margin: 0;">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}" style="color: #78e518; text-decoration: none;">
                    <i class="fas fa-home me-1"></i>{{ __('Home') }}
                </a>
            </li>
            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.5);">
                {{ $car->brand }} {{ $car->model }}
            </li>
        </ol>
    </nav>

    <!-- Car Details Card -->
    <div class="card border-0 shadow-lg fade-in-up"
        style="background: rgba(30, 35, 42, 0.95); border-radius: 20px; overflow: hidden; border: 1px solid rgba(255,255,255,0.06) !important;">
        <div class="card-body p-0">
            <div class="row g-0">
                <!-- Image Carousel Section -->
                <div class="col-lg-7 position-relative">
                    @guest
                    <button class="toggle-favorite" data-car-id="{{ $car->id }}"
                        style="top: 20px; right: 20px; z-index: 20;">
                        <i class="fas fa-heart"></i>
                    </button>
                    @endguest
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
                                aria-label="{{ __('Slide') }} {{ $index + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                            @foreach($allImages as $index => $image)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                <img src="{{ Str::startsWith($image, 'http') ? $image : asset('storage/' . $image) }}"
                                    class="d-block w-100 car-detail-image"
                                    alt="{{ $car->brand }} {{ $car->model }} - Image {{ $index + 1 }}"
                                    style="max-height: 550px; object-fit: cover;">
                            </div>
                            @endforeach
                        </div>
                        @if(count($allImages) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('Previous') }}</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">{{ __('Next') }}</span>
                        </button>
                        @endif
                    </div>

                    <!-- Thumbnail Strip -->
                    @if(count($allImages) > 1)
                    <div class="thumbnail-strip d-flex gap-2 p-3"
                        style="background: rgba(18, 22, 28, 0.8); overflow-x: auto;">
                        @foreach($allImages as $index => $image)
                        <img src="{{ Str::startsWith($image, 'http') ? $image : asset('storage/' . $image) }}"
                            class="thumb-img {{ $index === 0 ? 'active' : '' }}" data-bs-target="#carImageCarousel"
                            data-bs-slide-to="{{ $index }}" alt="Thumbnail {{ $index + 1 }}"
                            style="width: 70px; height: 50px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent; opacity: 0.6; transition: all 0.3s ease;">
                        @endforeach
                    </div>
                    @endif

                    @else
                    <div class="d-flex align-items-center justify-content-center"
                        style="height: 550px; background: linear-gradient(135deg, #2a2f38, #1e2329);">
                        <i class="fas fa-car fa-5x" style="color: rgba(255,255,255,0.1);"></i>
                    </div>
                    @endif
                </div>

                <!-- Details Section -->
                <div class="col-lg-5">
                    <div class="p-4 p-lg-5">
                        <!-- Title and Price -->
                        <h1 class="mb-2 text-white" style="font-weight: 800; font-size: 2rem; letter-spacing: -0.5px;">
                            {{ $car->brand }} {{ $car->model }}
                        </h1>
                        <div class="price-tag mb-4" style="font-size: 2.2rem; color: #78e518;" id="animatedPrice"
                            data-price="{{ $car->price }}">
                            {{ number_format($car->price, 0) }} €
                        </div>

                        <!-- Primary Badges -->
                        <div class="d-flex flex-wrap gap-2 mb-4">
                            <span class="detail-badge">
                                <i class="fas fa-check-circle me-1"></i>{{ ucfirst($car->condition) }}
                            </span>
                            <span class="detail-badge">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $car->year }}
                            </span>
                            <span class="detail-badge">
                                <i class="fas fa-cogs me-1"></i>{{ ucfirst($car->transmission) }}
                            </span>
                            <span class="detail-badge">
                                <i class="fas fa-gas-pump me-1"></i>{{ ucfirst($car->fuel_type) }}
                            </span>
                            @if($car->category)
                            <span class="detail-badge">
                                <i class="fas fa-tag me-1"></i>{{ $car->category }}
                            </span>
                            @endif
                        </div>

                        <!-- Specifications Grid -->
                        <div class="mb-4">
                            <h6 class="text-uppercase mb-3"
                                style="letter-spacing: 1.5px; color: rgba(255,255,255,0.4); font-size: 0.75rem; font-weight: 600;">
                                <i class="fas fa-cog me-1"></i>{{ __('Specifications') }}
                            </h6>

                            <div class="row g-2">
                                @if($car->mileage!==null)
                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon"><i class="fas fa-tachometer-alt"></i></div>
                                        <div class="spec-label">{{ __('Mileage') }}</div>
                                        <div class="spec-value">{{ number_format($car->mileage) }} km</div>
                                    </div>
                                </div>
                                @endif

                                @if($car->performance)
                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon" style="color: #ff6b6b;"><i class="fas fa-bolt"></i></div>
                                        <div class="spec-label">{{ __('Power') }}</div>
                                        <div class="spec-value">{{ $car->performance }} kW ({{ ceil($car->performance *
                                            1.34) }} HP)</div>
                                    </div>
                                </div>
                                @endif

                                @if($car->consumption)
                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon" style="color: #4ecdc4;"><i class="fas fa-gas-pump"></i>
                                        </div>
                                        <div class="spec-label">{{ __('Consumption') }}</div>
                                        <div class="spec-value">{{ $car->consumption }} l/100km</div>
                                    </div>
                                </div>
                                @endif

                                @if($car->number_of_seats)
                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon" style="color: #667eea;"><i class="fas fa-users"></i>
                                        </div>
                                        <div class="spec-label">{{ __('Seats') }}</div>
                                        <div class="spec-value">{{ $car->number_of_seats }} {{ __('Seats') }}</div>
                                    </div>
                                </div>
                                @endif

                                @if($car->color)
                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon" style="color: #feca57;"><i class="fas fa-palette"></i>
                                        </div>
                                        <div class="spec-label">{{ __('Color') }}</div>
                                        <div class="spec-value">{{ ucfirst($car->color) }}</div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-6">
                                    <div class="spec-card">
                                        <div class="spec-icon" style="color: #ff9ff3;"><i class="fas fa-calendar"></i>
                                        </div>
                                        <div class="spec-label">{{ __('Year') }}</div>
                                        <div class="spec-value">{{ $car->year }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contact CTA -->
                        <div class="contact-cta-card p-4 mb-3">
                            <h6 class="mb-3 text-white fw-bold">
                                <i class="fas fa-handshake me-2"></i>{{ __('Interested in this car?') }}
                            </h6>
                            <p class="mb-2 small" style="color: rgba(255,255,255,0.7);">
                                <strong class="text-white">{{ __('Car ID:') }}</strong> {{ str_pad($car->id, 6, '0',
                                STR_PAD_LEFT) }}
                            </p>
                            <div class="d-flex flex-column gap-2">
                                <a href="mailto:{{ $settings->email }}" class="btn btn-contact-outline">
                                    <i class="fas fa-envelope me-2"></i>{{ $settings->email }}
                                </a>
                                <a href="tel:{{ $settings->phone }}" class="btn btn-contact-outline">
                                    <i class="fas fa-phone me-2"></i>{{ $settings->phone }}
                                </a>
                                <div class="btn btn-contact-outline" style="cursor: default; text-align: left;">
                                    <i class="fab fa-whatsapp me-2" style="color: #25d366;"></i>{{ $settings->phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            @if($car->description)
            <div class="p-4 p-lg-5" style="border-top: 1px solid rgba(255,255,255,0.06);">
                <h5 class="mb-3 text-uppercase"
                    style="letter-spacing: 1.5px; color: rgba(255,255,255,0.4); font-size: 0.8rem; font-weight: 600;">
                    <i class="fas fa-info-circle me-2"></i>{{ __('Description') }}
                </h5>
                <p class="text-white" style="line-height: 1.9; font-size: 1rem; opacity: 0.85;">{{ $car->description }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-4 text-center fade-in-up">
        <a href="{{ route('home') }}" class="btn btn-back px-5 py-3">
            <i class="fas fa-arrow-left me-2 back-arrow"></i>{{ __('View More Cars') }}
        </a>
    </div>
</div>

<style>
    .car-detail-image {
        transition: transform 0.4s ease;
    }

    .carousel-item:hover .car-detail-image {
        transform: scale(1.02);
    }

    .thumb-img.active,
    .thumb-img:hover {
        opacity: 1 !important;
        border-color: #78e518 !important;
    }

    .detail-badge {
        background: rgba(120, 229, 24, 0.1);
        color: #8fff2e;
        border: 1px solid rgba(120, 229, 24, 0.15);
        padding: 6px 14px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .detail-badge:hover {
        background: rgba(120, 229, 24, 0.18);
        transform: translateY(-2px);
    }

    .spec-card {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 12px;
        padding: 14px;
        transition: all 0.3s ease;
        text-align: center;
    }

    .spec-card:hover {
        transform: translateY(-4px);
        border-color: rgba(120, 229, 24, 0.25);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .spec-icon {
        font-size: 1.3rem;
        margin-bottom: 6px;
        color: #78e518;
    }

    .spec-icon i {
        background: rgba(255, 255, 255, 0.06);
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .spec-label {
        font-size: 0.72rem;
        color: rgba(255, 255, 255, 0.45);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .spec-value {
        font-size: 0.88rem;
        color: #fff;
        font-weight: 700;
    }

    .contact-cta-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15), rgba(118, 75, 162, 0.15));
        border: 1px solid rgba(102, 126, 234, 0.2);
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .contact-cta-card:hover {
        border-color: rgba(102, 126, 234, 0.35);
        box-shadow: 0 8px 30px rgba(102, 126, 234, 0.15);
    }

    .btn-contact-outline {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.85);
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.85rem;
        text-align: left;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-contact-outline:hover {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-color: rgba(255, 255, 255, 0.2);
    }

    .whatsapp-cta-btn {
        background: linear-gradient(135deg, #25d366, #128c7e);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 10px 16px;
        font-size: 0.9rem;
        font-weight: 600;
        text-align: center;
        transition: all 0.3s ease;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25);
    }

    .whatsapp-cta-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
        color: white;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.85);
        border-radius: 14px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(120, 229, 24, 0.3);
        color: #78e518;
    }

    .btn-back:hover .back-arrow {
        transform: translateX(-4px);
    }

    .back-arrow {
        transition: transform 0.3s ease;
    }

    .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.3);
        content: "›";
        font-size: 1.1rem;
    }

    @media (max-width: 991px) {
        .car-detail-image {
            max-height: 400px !important;
        }
    }
</style>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Recently Viewed tracking
        const carId = {{ $car-> id
    }};
    let recentlyViewed = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    recentlyViewed = recentlyViewed.filter(id => id !== carId);
    recentlyViewed.unshift(carId);
    recentlyViewed = recentlyViewed.slice(0, 10);
    localStorage.setItem('recentlyViewed', JSON.stringify(recentlyViewed));

    // Thumbnail active state sync
    const carousel = document.getElementById('carImageCarousel');
    if (carousel) {
        carousel.addEventListener('slid.bs.carousel', function (event) {
            document.querySelectorAll('.thumb-img').forEach(function (t) { t.classList.remove('active'); });
            const activeThumb = document.querySelector(`.thumb-img[data-bs-slide-to="${event.to}"]`);
            if (activeThumb) activeThumb.classList.add('active');
        });
    }

    // Animated price count-up
    const priceEl = document.getElementById('animatedPrice');
    if (priceEl) {
        const targetPrice = parseInt(priceEl.dataset.price);
        let current = 0;
        const duration = 1200;
        const start = performance.now();

        function animatePrice(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            current = Math.floor(targetPrice * eased);
            priceEl.textContent = current.toLocaleString() + ' €';
            if (progress < 1) requestAnimationFrame(animatePrice);
        }

        // Only animate when visible
        const observer = new IntersectionObserver(function (entries) {
            if (entries[0].isIntersecting) {
                requestAnimationFrame(animatePrice);
                observer.unobserve(priceEl);
            }
        });
        observer.observe(priceEl);
    }
    });
</script>
@endsection
@endsection