@extends('layouts.app')
@section('title', $settings->name)

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

<div class="hero" style="background-image: url('{{ asset('storage/' . $settings->image) }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="display-4 mb-3">{{ $settings->description }}</h1>
    </div>
</div>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-4 text-white">Available Cars</h2>
            
            <!-- Search and Filter -->
            <div class="card bg-dark text-white p-4 mb-4">
                <div class="row g-3">
                    <!-- Brand -->
                    <div class="col-md-3">
                        <label class="form-label small">Brand</label>
                        <select id="brandFilter" class="form-select">
                            <option value="">Any</option>
                            @foreach($cars->unique('brand')->pluck('brand') as $brand)
                                <option value="{{ strtolower($brand) }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Model -->
                    <div class="col-md-3">
                        <label class="form-label small">Model</label>
                        <select id="modelFilter" class="form-select">
                            <option value="">Any</option>
                            @foreach($cars->unique('model')->pluck('model') as $model)
                                <option value="{{ strtolower($model) }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- First Registration -->
                    <div class="col-md-3">
                        <label class="form-label small">First Registration From</label>
                        <select id="yearFilter" class="form-select">
                            <option value="">Any</option>
                            @for($year = date('Y'); $year >= 1990; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- Mileage Up To -->
                    <div class="col-md-3">
                        <label class="form-label small">Mileage Up To</label>
                        <select id="mileageFilter" class="form-select">
                            <option value="">Any</option>
                            <option value="50000">50,000 km</option>
                            <option value="100000">100,000 km</option>
                            <option value="150000">150,000 km</option>
                            <option value="200000">200,000 km</option>
                        </select>
                    </div>
                    
                    <!-- Payment Type -->
                    <div class="col-md-3">
                        <label class="form-label small">Payment Type</label>
                        <select id="conditionFilter" class="form-select">
                            <option value="">Any</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                    
                    <!-- Price Up To -->
                    <div class="col-md-3">
                        <label class="form-label small">Price Up To</label>
                        <select id="priceFilter" class="form-select">
                            <option value="">Any</option>
                            <option value="10000">$10,000</option>
                            <option value="20000">$20,000</option>
                            <option value="30000">$30,000</option>
                            <option value="50000">$50,000</option>
                            <option value="75000">$75,000</option>
                            <option value="100000">$100,000</option>
                        </select>
                    </div>
                    
                    <!-- Location -->
                    <div class="col-md-3">
                        <label class="form-label small">City or Zip Code</label>
                        <input type="text" id="locationFilter" class="form-control" placeholder="Any">
                    </div>
                    
                    <!-- Search Buttons -->
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button id="searchButton" class="btn btn-danger flex-grow-1">
                            <i class="fas fa-search me-2"></i><span id="resultsCount">{{ $cars->count() }} Results</span>
                        </button>
                    </div>
                </div>
                
                <!-- Additional Options Row -->
                <div class="row mt-3">
                    <div class="col-md-12 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="electricOnly">
                            <label class="form-check-label" for="electricOnly">
                                <i class="fas fa-bolt"></i> Electric Only
                            </label>
                        </div>
                        <div>
                            <button id="resetFilters" class="btn btn-link text-white text-decoration-none">
                                <i class="fas fa-undo"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="carsContainer">
        @forelse($cars as $car)
        <div class="col-md-4 car-item" 
             data-brand="{{ strtolower($car->brand) }}" 
             data-model="{{ strtolower($car->model) }}"
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
                    <img src="{{ asset('storage/' . $car->image) }}" class="card-img-top car-image" alt="{{ $car->brand }} {{ $car->model }}">
                @else
                    <div class="car-image bg-secondary d-flex align-items-center justify-content-center">
                        <i class="fas fa-car fa-5x text-white"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title text-light">{{ $car->brand }} {{ $car->model }}</h5>
                    <p class="price-tag mb-2">${{ number_format($car->price, 0) }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary badge-custom">{{ ucfirst($car->condition) }}</span>
                        <span class="badge bg-info badge-custom">{{ $car->year }}</span>
                        <span class="badge bg-warning text-dark badge-custom">{{ ucfirst($car->transmission) }}</span>
                    </div>
                    
                    <p class="card-text text-muted small">
                        <span class="text-white">
                            <i class="fas fa-gas-pump text-white"></i> {{ ucfirst($car->fuel_type) }}
                        </span>
                        @if($car->mileage)
                            | <i class="fas fa-tachometer-alt"></i> {{ number_format($car->mileage) }} km
                        @endif
                    </p>
                    
                    <p class="card-text">{{ Str::limit($car->description, 100) }}</p>
                    
                    <button class="btn btn-primary w-100 view-details" data-car-id="{{ $car->id }}">
                        View Details
                    </button>
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
    </div>
    
    <div id="noResults" class="alert alert-warning text-center" style="display: none;">
        <i class="fas fa-search"></i> No cars found matching your criteria.
    </div>
</div>

<!-- Car Details Modal -->
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
window.addEventListener('scroll', function() {
    const hero = document.querySelector('.hero');
    const heroTexts = document.querySelectorAll('.hero h1, .hero p');
    const scrolled = window.pageYOffset;
    const heroHeight = hero.offsetHeight;
    
    const opacity = 1 - (scrolled / heroHeight);
    heroTexts.forEach(function(text) {
        if (opacity >= 0) {
            text.style.opacity = opacity;
        }
    });
});

$(document).ready(function() {
    const cars = @json($cars);
    
    // Filter functionality
    function filterCars() {
        const brand = $('#brandFilter').val();
        const model = $('#modelFilter').val();
        const year = $('#yearFilter').val();
        const mileage = $('#mileageFilter').val();
        const condition = $('#conditionFilter').val();
        const price = $('#priceFilter').val();
        const electricOnly = $('#electricOnly').is(':checked');
        
        let visibleCount = 0;
        
        $('.car-item').each(function() {
            const carBrand = $(this).data('brand');
            const carModel = $(this).data('model');
            const carYear = $(this).data('year');
            const carMileage = $(this).data('mileage');
            const carCondition = $(this).data('condition');
            const carPrice = $(this).data('price');
            const carFuel = $(this).data('fuel');
            
            const matchesBrand = !brand || carBrand === brand;
            const matchesModel = !model || carModel === model;
            const matchesYear = !year || carYear == parseInt(year);
            const matchesMileage = !mileage || carMileage <= parseInt(mileage);
            const matchesCondition = !condition || carCondition === condition;
            const matchesPrice = !price || carPrice <= parseInt(price);
            const matchesElectric = !electricOnly || carFuel === 'electric';
            
            if (matchesBrand && matchesModel && matchesYear && matchesMileage && matchesCondition && matchesPrice && matchesElectric) {
                $(this).fadeIn();
                visibleCount++;
            } else {
                $(this).fadeOut();
            }
        });
        
        $('#resultsCount').text(`${visibleCount} Result${visibleCount !== 1 ? 's' : ''}`);
        $('#noResults').toggle(visibleCount === 0);
    }
    
    // Bind filter events
    $('#brandFilter, #modelFilter, #yearFilter, #mileageFilter, #conditionFilter, #priceFilter').on('change', filterCars);
    $('#electricOnly').on('change', filterCars);
    $('#searchButton').on('click', filterCars);
    
    // Reset filters
    $('#resetFilters').on('click', function() {
        $('#brandFilter').val('');
        $('#modelFilter').val('');
        $('#yearFilter').val('');
        $('#mileageFilter').val('');
        $('#conditionFilter').val('');
        $('#priceFilter').val('');
        $('#locationFilter').val('');
        $('#electricOnly').prop('checked', false);
        filterCars();
    });
    
    // View details with image carousel
    $('.view-details').on('click', function() {
        const carId = $(this).data('car-id');
        const car = cars.find(c => c.id === carId);
        
        if (car) {
            $('#modalTitle').text(`${car.brand} ${car.model} (${car.year})`);
            
            // Build image carousel
            let carouselHtml = '';
            const allImages = [];
            
            // Add main image first
            if (car.image) {
                allImages.push(car.image);
            }
            
            // Add additional images
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
                <p class="price-tag mb-3">$${car.price.toLocaleString()}</p>
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
                ${car.mileage ? `<p><strong>Mileage:</strong> ${car.mileage.toLocaleString()} km</p>` : ''}
                <p><strong>Description:</strong></p>
                <p>${car.description}</p>
            `);
            
            $('#carModal').modal('show');
        }
    });
});
</script>
@endsection