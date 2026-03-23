@extends('layouts.app')
@section('title', __('My Favorites') . ' - ' . $settings->name)

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
                {{ __('Favorites') }}
            </li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="text-white fade-in-up" style="font-weight: 800; letter-spacing: -0.5px;">
                <i class="fas fa-heart me-2" style="color: #ff4757;"></i> {{ __('My Favorites') }}
            </h2>
        </div>
    </div>

    <div class="row g-3" id="favoritesContainer">
        <div class="col-12 text-center py-5" id="noFavorites">
            <div class="empty-state-card mx-auto" style="max-width: 420px;">
                <div class="empty-heart-icon mb-4">
                    <i class="fas fa-heart"></i>
                </div>
                <h4 class="text-white mb-2" style="font-weight: 700;">{{ __('No favorites yet') }}</h4>
                <p style="color: rgba(255,255,255,0.5); font-size: 0.95rem;">{{ __('Start adding cars to your favorites
                    by clicking the heart icon') }}</p>
                <a href="{{ route('home') }}" class="btn btn-browse mt-2">
                    <i class="fas fa-car me-2"></i>{{ __('Browse Cars') }}
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-item+.breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.3);
        content: "›";
        font-size: 1.1rem;
    }

    .empty-state-card {
        background: rgba(30, 35, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 24px;
        padding: 50px 30px;
    }

    .empty-heart-icon {
        width: 90px;
        height: 90px;
        margin: 0 auto;
        background: rgba(255, 71, 87, 0.08);
        border: 2px solid rgba(255, 71, 87, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: heartFloat 3s ease-in-out infinite;
    }

    .empty-heart-icon i {
        font-size: 2.2rem;
        color: rgba(255, 71, 87, 0.4);
    }

    @keyframes heartFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    .btn-browse {
        background: linear-gradient(135deg, #5cb510, #3d8a08);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 28px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(92, 181, 16, 0.25);
        text-decoration: none;
    }

    .btn-browse:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(92, 181, 16, 0.4);
        color: white;
    }

    .fav-card-remove {
        background: rgba(255, 71, 87, 0.1);
        border: 1px solid rgba(255, 71, 87, 0.2);
        color: #ff4757;
        border-radius: 10px;
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .fav-card-remove:hover {
        background: rgba(255, 71, 87, 0.2);
        transform: scale(1.1);
        color: #ff6b81;
    }

    .fav-card-col {
        transition: all 0.4s ease;
    }

    .fav-card-col.removing {
        opacity: 0;
        transform: scale(0.85);
    }
</style>

@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');

        if (favorites.length === 0) {
            $('#noFavorites').show();
            return;
        }

        $('#noFavorites').hide();

        $.ajax({
            url: '/api/cars/favorites',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({ ids: favorites }),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (cars) {
                displayFavorites(cars);
            },
            error: function () {
                $('#favoritesContainer').html(`
                <div class="col-12">
                    <div class="text-center py-4" style="background: rgba(255, 71, 87, 0.06); border: 1px solid rgba(255, 71, 87, 0.15); border-radius: 14px; color: #ff6b81;">
                        <i class="fas fa-exclamation-triangle fa-2x mb-2 d-block" style="opacity: 0.5;"></i>
                        {{ __('Failed to load favorites') }}
                    </div>
                </div>
            `);
            }
        });

        function displayFavorites(cars) {
            if (cars.length === 0) {
                $('#noFavorites').show();
                return;
            }

            let html = '';
            cars.forEach((car, index) => {
                const imageSrc = car.image
                    ? (car.image.startsWith('http') ? car.image : '/storage/' + car.image)
                    : null;

                html += `
                <div class="col-6 col-md-4 fav-card-col" style="animation: cardFadeIn 0.5s ease forwards; animation-delay: ${index * 0.08}s; opacity: 0;">
                    <div class="card car-card h-100">
                        ${imageSrc
                        ? `<div class="card-img-wrapper"><img src="${imageSrc}" class="card-img-top car-image" alt="${car.brand} ${car.model}"><div class="car-image-overlay"><span class="text-white fw-semibold" style="font-size: 0.85rem; opacity: 0.9;"><i class="fas fa-eye me-1"></i>View Details</span></div></div>`
                        : `<div class="car-image d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2a2f38, #1e2329);"><i class="fas fa-car fa-4x" style="color: rgba(255,255,255,0.1);"></i></div>`
                    }
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="text-white fw-semibold mb-0" style="font-size: 0.95rem;">${car.brand} ${car.model}</h6>
                                <button class="fav-card-remove remove-favorite" data-car-id="${car.id}" title="{{ __('Remove from favorites') }}">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>
                            <p class="price-tag mb-2">${Number(car.price).toLocaleString()} €</p>
                            
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge badge-premium"><i class="fas fa-check-circle me-1" style="font-size: 0.6rem;"></i>${car.condition.charAt(0).toUpperCase() + car.condition.slice(1)}</span>
                                <span class="badge badge-premium"><i class="fas fa-calendar-alt me-1" style="font-size: 0.6rem;"></i>${car.year}</span>
                                <span class="badge badge-premium"><i class="fas fa-cogs me-1" style="font-size: 0.6rem;"></i>${car.transmission.charAt(0).toUpperCase() + car.transmission.slice(1)}</span>
                            </div>
                            
                            <p class="card-text small mb-3" style="color: rgba(255,255,255,0.5);">
                                <i class="fas fa-gas-pump me-1" style="color: #78e518;"></i>
                                <span class="text-white">${car.fuel_type.charAt(0).toUpperCase() + car.fuel_type.slice(1)}</span>
                                ${car.mileage ? `<span class="mx-1">·</span><i class="fas fa-tachometer-alt me-1" style="color: #78e518;"></i>${Number(car.mileage).toLocaleString()} km` : ''}
                            </p>
                            
                            <a href="/cars/${car.id}" class="btn btn-detail w-100">
                                {{ __('View Details') }} <i class="fas fa-arrow-right ms-1 btn-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
            });

            $('#favoritesContainer').html(html);

            // Remove from favorites
            $('.remove-favorite').on('click', function () {
                const carId = $(this).data('car-id');
                removeFavorite(carId);
                const col = $(this).closest('.fav-card-col');
                col.addClass('removing');
                setTimeout(function () {
                    col.remove();
                    if ($('#favoritesContainer .fav-card-col').length === 0) {
                        $('#noFavorites').show();
                    }
                }, 400);
            });
        }

        function removeFavorite(carId) {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            favorites = favorites.filter(id => id != carId);
            localStorage.setItem('favorites', JSON.stringify(favorites));
            if (typeof updateFavoritesCount === 'function') {
                updateFavoritesCount();
            }
        }
    });
</script>

<style>
    @keyframes cardFadeIn {
        from {
            opacity: 0;
            transform: translateY(25px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

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
        text-decoration: none;
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

    .card-img-wrapper {
        overflow: hidden;
        position: relative;
        border-radius: 14px 14px 0 0;
    }

    .car-image-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 20px;
        z-index: 2;
    }

    .car-card:hover .car-image-overlay {
        opacity: 1;
    }
</style>
@endsection