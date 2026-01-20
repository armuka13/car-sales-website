@extends('layouts.app')
@section('title', 'My Favorites - ' . $settings->name)

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4 text-white">
                <i class="fas fa-heart text-danger"></i> My Favorites
            </h2>
        </div>
    </div>

    <div class="row" id="favoritesContainer">
        <div class="col-12 text-center py-5" id="noFavorites">
            <i class="fas fa-heart-broken fa-5x text-muted mb-3"></i>
            <h4 class="text-white">No favorites yet</h4>
            <p class="text-white">Start adding cars to your favorites by clicking the heart icon</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="fas fa-car"></i> Browse Cars
            </a>
        </div>
    </div>
</div>

<!-- Car Details Modal (same as home page) -->
<div class="modal fade" id="carModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <div class="w-100 text-center">
                    <p class="mb-2"><strong>Contact us to schedule a test drive:</strong></p>
                    <p class="mb-1"><i class="fas fa-envelope"></i> {{ $settings->email }}</p>
                    <p class="mb-0"><i class="fas fa-phone"></i> {{ $settings->phone }}</p>
                </div>
            </div>
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
                        <i class="fas fa-exclamation-triangle"></i> Failed to load favorites
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
                            ? `<img src="/storage/${car.image}" class="card-img-top car-image" alt="${car.brand} ${car.model}">`
                            : `<div class="car-image bg-secondary d-flex align-items-center justify-content-center">
                                <i class="fas fa-car fa-5x text-white"></i>
                               </div>`
                        }
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title text-light mb-0">${car.brand} ${car.model}</h5>
                                <button class="btn btn-link text-danger p-0 remove-favorite" data-car-id="${car.id}" title="Remove from favorites">
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
                            
                            <button class="btn btn-primary w-100 view-details" data-car-id="${car.id}">
                                View Details
                            </button>
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
        
        // View details
        $('.view-details').on('click', function() {
            const carId = $(this).data('car-id');
            const car = cars.find(c => c.id == carId);
            showCarDetails(car);
        });
    }
    
    function removeFavorite(carId) {
        let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        favorites = favorites.filter(id => id != carId);
        localStorage.setItem('favorites', JSON.stringify(favorites));
        updateFavoritesCount();
    }
    
    function showCarDetails(car) {
        $('#modalTitle').text(`${car.brand} ${car.model} (${car.year})`);
        
        // Build image carousel
        let carouselHtml = '';
        const allImages = [];
        
        if (car.image) {
            allImages.push(car.image);
        }
        
        if (car.images && car.images.length > 0) {
            allImages.push(...car.images);
        }
        
        if (allImages.length > 0) {
            carouselHtml = `
                <div id="carImageCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        ${allImages.map((img, index) => `
                            <button type="button" data-bs-target="#carImageCarousel" data-bs-slide-to="${index}" 
                                ${index === 0 ? 'class="active" aria-current="true"' : ''} 
                                aria-label="Slide ${index + 1}"></button>
                        `).join('')}
                    </div>
                    <div class="carousel-inner">
                        ${allImages.map((img, index) => `
                            <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                <img src="/storage/${img}" class="d-block w-100" alt="${car.brand} ${car.model} - Image ${index + 1}">
                            </div>
                        `).join('')}
                    </div>
                    ${allImages.length > 1 ? `
                        <button class="carousel-control-prev" type="button" data-bs-target="#carImageCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carImageCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    ` : ''}
                </div>
            `;
        } else {
            carouselHtml = '<div class="bg-secondary p-5 text-center mb-3"><i class="fas fa-car fa-5x text-white"></i></div>';
        }
        
        $('#modalBody').html(`
            ${carouselHtml}
            <p class="price-tag mb-3">$${Number(car.price).toLocaleString()}</p>
            <div class="mb-3">
                <span class="badge bg-primary badge-custom">${car.condition.charAt(0).toUpperCase() + car.condition.slice(1)}</span>
                <span class="badge bg-info badge-custom">${car.year}</span>
                <span class="badge bg-warning text-dark badge-custom">${car.transmission.charAt(0).toUpperCase() + car.transmission.slice(1)}</span>
                <span class="badge bg-success badge-custom">${car.fuel_type.charAt(0).toUpperCase() + car.fuel_type.slice(1)}</span>
                ${car.performance ? `<span class="badge bg-secondary badge-custom">${car.performance + ' kW ('+ Math.ceil(car.performance * 1.34)+' HP)'}</span>` : ''}
                ${car.consumption ? `<span class="badge bg-danger badge-custom">${car.consumption + ' l/100km'}</span>` : ''}
                ${car.number_of_seats ? `<span class="badge bg-dark badge-custom">${car.number_of_seats} Seats</span>` : ''}
                ${car.color ? `<span class="badge bg-light badge-custom text-dark">${car.color.charAt(0).toUpperCase() + car.color.slice(1)}</span>` : ''}
            </div>
            ${car.mileage ? `<p><strong>Mileage:</strong> ${Number(car.mileage).toLocaleString()} km</p>` : ''}
            <p><strong>Description:</strong></p>
            <p>${car.description}</p>
        `);
        
        $('#carModal').modal('show');
    }
});
</script>
@endsection