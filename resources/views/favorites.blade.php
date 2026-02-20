@extends('layouts.app')
@section('title', __('My Favorites') . ' - ' . $settings->name)

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4 text-white">
                <i class="fas fa-heart text-danger"></i> {{ __('My Favorites') }}
            </h2>
        </div>
    </div>

    <div class="row" id="favoritesContainer">
        <div class="col-12 text-center py-5" id="noFavorites">
            <i class="fas fa-heart-broken fa-5x text-muted mb-3"></i>
            <h4 class="text-white">{{ __('No favorites yet') }}</h4>
            <p class="text-white">{{ __('Start adding cars to your favorites by clicking the heart icon') }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fas fa-car"></i> {{ __('Browse Cars') }}
            </a>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Get favorites from localStorage
    let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
    
    if (favorites.length === 0) {
        $('#noFavorites').show();
        return;
    }
    
    $('#noFavorites').hide();
    
    // Fetch favorite cars from server
    $.ajax({
        url: '/api/cars/favorites',
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({ ids: favorites }),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(cars) {
            displayFavorites(cars);
        },
        error: function() {
            $('#favoritesContainer').html(`
                <div class="col-12">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle"></i> {{ __('Failed to load favorites') }}
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
        cars.forEach(car => {
            html += `
                <div class="col-md-4 mb-4">
                    <div class="card car-card bg-dark">
                        ${car.image 
                            ? `<img src="${car.image.startsWith('http') ? car.image : '/storage/' + car.image}" class="card-img-top car-image" alt="${car.brand} ${car.model}">`
                            : `<div class="car-image bg-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-car fa-5x text-white"></i>
                               </div>`
                        }
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title text-light mb-0">${car.brand} ${car.model}</h5>
                                <button class="btn btn-link text-danger p-0 remove-favorite" data-car-id="${car.id}" title="{{ __('Remove from favorites') }}">
                                    <i class="fas fa-heart fa-lg"></i>
                                </button>
                            </div>
                            <p class="price-tag mb-2">$${Number(car.price).toLocaleString()}</p>
                            
                            <div class="mb-3">
                                <span class="badge bg-primary badge-custom">${car.condition.charAt(0).toUpperCase() + car.condition.slice(1)}</span>
                                <span class="badge bg-info badge-custom">${car.year}</span>
                                <span class="badge bg-warning text-dark badge-custom">${car.transmission.charAt(0).toUpperCase() + car.transmission.slice(1)}</span>
                            </div>
                            
                            <p class="card-text text-muted small">
                                <i class="fas fa-gas-pump text-white"></i> <span class="text-white">${car.fuel_type.charAt(0).toUpperCase() + car.fuel_type.slice(1)}</span>
                                ${car.mileage ? `| <i class="fas fa-tachometer-alt"></i> ${Number(car.mileage).toLocaleString()} km` : ''}
                            </p>
                            
                            <p class="card-text">${car.description.substring(0, 100)}${car.description.length > 100 ? '...' : ''}</p>
                            
                            <a href="/cars/${car.id}" class="btn btn-primary w-100">
                                {{ __('View Details') }}
                            </a>
                        </div>
                    </div>
                </div>
            `;
        });
        
        $('#favoritesContainer').html(html);
        
        // Remove from favorites
        $('.remove-favorite').on('click', function() {
            const carId = $(this).data('car-id');
            removeFavorite(carId);
            $(this).closest('.col-md-4').fadeOut(300, function() {
                $(this).remove();
                
                // Check if no favorites left
                if ($('#favoritesContainer .col-md-4').length === 0) {
                    $('#noFavorites').show();
                }
            });
        });
        

    }

    function removeFavorite(carId) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites = favorites.filter(id => id != carId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        // Try to update count if function exists
        if (typeof updateFavoritesCount === 'function') {
            updateFavoritesCount();
        }
    }
});
</script>
@endsection