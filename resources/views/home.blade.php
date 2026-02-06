@extends('layouts.app')
@section('title', $settings->name)

@section('content')
<div class="contact-bar">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-6">
                <i class="fas fa-envelope"></i> Email: 
                <a href="mailto:{{ $settings->email }}" class="text-white text-decoration-none">
                    <strong>{{ $settings->email }}</strong>
                </a>
            </div>
            <div class="col-md-6">
                <i class="fas fa-phone"></i> Phone: 
                <a href="tel:{{ $settings->phone }}" class="text-white text-decoration-none">
                    <strong>{{ $settings->phone }}</strong>
                </a>
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
            


            <h2 class="mb-4 text-orange d-md-block">Available Cars</h2>
            
            <!-- Search and Filter -->
            <div class="d-md-none mb-3">
                <button class="btn btn-orange w-100" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
                    <i class="fas fa-filter me-2"></i>Show Filters
                </button>
            </div>
            
            <div class="collapse d-md-block" id="filterCollapse">
                <div class="card bg-dark text-white p-4 mb-4">
                <div class="row g-3">


                    <!-- Category -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Category</label>
                        <select id="categoryFilter" class="form-select custom-input">
                            <option value="">Any</option>
                            @foreach($cars->unique('category')->pluck('category') as $category)
                                <option value="{{ strtolower($category) }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Brand</label>
                        <select id="brandFilter" class="form-select custom-input">
                            <option value="">Any</option>
                            @foreach($cars->unique('brand')->pluck('brand') as $brand)
                                <option value="{{ strtolower($brand) }}">{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Model -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Model</label>
                        <select id="modelFilter" class="form-select custom-input text-danger bg-dark" disabled>
                            <option value="">Select Brand First</option>
                        </select>
                    </div>
                    
                    <!-- First Registration -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Year from</label>
                        <select id="yearFilter" class="form-select custom-input">
                            <option value="">Any</option>
                            @for($year = date('Y'); $year >= 1990; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- Mileage Up To -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Mileage Up To</label>
                        <select id="mileageFilter" class="form-select custom-input">
                            <option value="">Any</option>
                            <option value="50000">50,000 km</option>
                            <option value="100000">100,000 km</option>
                            <option value="150000">150,000 km</option>
                            <option value="200000">200,000 km</option>
                        </select>
                    </div>

                     <!-- Price Up To -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">Price Up To</label>
                        <select id="priceFilter" class="form-select custom-input">
                            <option value="">Any</option>
                            <option value="5000">$5,000</option>
                            <option value="10000">$10,000</option>
                            <option value="20000">$20,000</option>
                            <option value="30000">$30,000</option>
                            <option value="50000">$50,000</option>
                            <option value="75000">$75,000</option>
                            <option value="100000">$100,000</option>
                        </select>
                    </div>
                    
                    <!-- Condition (Custom Toggle) -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small">Condition</label>
                        <div class="payment-toggle-container d-md-none">
                             <input type="radio" class="btn-check" name="conditionToggle" id="conditionAny" value="" checked>
                             <label class="btn btn-outline-custom w-33" for="conditionAny">Any</label>

                             <input type="radio" class="btn-check" name="conditionToggle" id="conditionNew" value="new">
                             <label class="btn btn-outline-custom w-33" for="conditionNew">New</label>

                             <input type="radio" class="btn-check" name="conditionToggle" id="conditionUsed" value="used">
                             <label class="btn btn-outline-custom w-33" for="conditionUsed">Used</label>
                        </div>
                        <select id="conditionFilter" class="form-select custom-input d-none d-md-block">
                            <option value="">Any</option>
                            <option value="new">New</option>
                            <option value="used">Used</option>
                        </select>
                    </div>
                    
                   
                    
                    <!-- Additional Filters Toggle (Mobile) -->
                    <div class="col-12 d-block d-md-none mt-3">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" id="electricOnlyMobile">
                                    <label class="form-check-label" for="electricOnlyMobile">
                                        Electric Only <i class="fas fa-charging-station"></i>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-6 d-flex align-items-center justify-content-end">
                                <i id="resetFiltersMobile" class="fas fa-undo text-orange" style="cursor: pointer; font-size: 1.1rem;" title="Reset Filters"></i>
                                <span class="text-orange ms-2" style="cursor: pointer; font-size: 0.9rem;"></span>
                            </div>
                        </div>
                    </div>
                
                    <!-- Electric Only & Reset (Desktop) - Same Row -->
                    <div class="col-12 d-none d-md-flex align-items-center justify-content-between mt-3">
                        <div class="form-check custom-checkbox">
                            <input class="form-check-input" type="checkbox" id="electricOnly">
                            <label class="form-check-label" for="electricOnly">
                                Electric Only <i class="fas fa-charging-station ms-1"></i>
                            </label>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <i id="resetFilters" class="fas fa-undo text-orange" style="cursor: pointer; font-size: 1.1rem;" title="Reset Filters"></i>
                            <span class="text-orange ms-2" style="cursor: pointer; font-size: 0.9rem;"></span>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            </div>

            <style>
                /* Custom Mobile Styling */
                .custom-input {
                    background-color: #212529; /* Dark background */
                    border: 1px solid #4a4a4a;
                    color: white;
                    border-radius: 8px;
                    padding: 10px 12px;
                }
                .custom-input:focus {
                    background-color: #2b3035;
                    color: white;
                    border-color: #a78bfa; /* Light purple focus */
                    box-shadow: none;
                }
                
                /* Search Bar Mockup */
                .search-bar-mockup {
                    background-color: #212529;
                    border: 1px solid #4a4a4a;
                    border-radius: 12px;
                    padding: 8px 15px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }
                .text-orange {
                    color: #e54b18;
                }
                
                /* Category Tabs */
                .category-tabs {
                    display: flex;
                    justify-content: space-between;
                    border-bottom: 1px solid #4a4a4a;
                    padding-bottom: 15px;
                    margin-bottom: 15px;
                }
                .category-tabs button {
                    background: none;
                    border: none;
                    color: #6c757d;
                    font-size: 1.2rem;
                    position: relative;
                }
                .category-tabs button.active {
                    color: #e54b18; /* Orange active */
                }
                .category-tabs button.active::after {
                    content: '';
                    position: absolute;
                    bottom: -16px;
                    left: 50%;
                    transform: translateX(-50%);
                    width: 100%;
                    height: 2px;
                    background-color: #e54b18;
                }
                .category-tabs .small-icon {
                    font-size: 0.6rem;
                    position: absolute;
                    top: 0;
                    right: -2px;
                }

                /* Payment Toggle */
                .payment-toggle-container {
                    display: flex;
                    background-color: #1a1d20;
                    border-radius: 8px;
                    padding: 2px;
                    border: 1px solid #4a4a4a;
                }
                .btn-outline-custom {
                    color: #adb5bd;
                    border: none;
                    flex: 1;
                    padding: 8px 0;
                    font-size: 0.9rem;
                    border-radius: 6px;
                }
                .btn-check:checked + .btn-outline-custom {
                    background-color: #2c2f33; /* Slightly lighter dark */
                    color: white;
                    border: 1px solid #6f42c1; /* Purple border */
                }
                
                /* Orange Search Button */
                .btn-orange {
                    background-color: #e54b18;
                    color: white;
                    border: none;
                    font-size: 1.1rem;
                }
                .btn-orange:hover {
                    background-color: #d14012;
                    color: white;
                }

                /* Checkbox styling */
                .custom-checkbox .form-check-input {
                    background-color: transparent;
                    border: 1px solid #6c757d;
                    width: 20px;
                    height: 20px;
                    border-radius: 6px;
                }
                .custom-checkbox .form-check-input:checked {
                    background-color: #212529;
                    border-color: #6c757d;
                }

                /* Remove form labels spacing on mobile */
                @media (max-width: 768px) {
                    .form-label {
                        margin-bottom: 4px;
                        font-weight: 500;
                        color: #dee2e6;
                    }
                }
            </style>
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
                        @if(isset($car->mileage))
                            | <i class="fas fa-tachometer-alt"></i> {{ number_format($car->mileage) }} km
                        @endif
                    </p>
                    
                    <p class="card-text">{{ Str::limit($car->description, 100) }}</p>
                    
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
    </div>
    
    <div id="noResults" class="alert alert-warning text-center" style="display: none;">
        <i class="fas fa-search"></i> No cars found matching your criteria.
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
        const condition = $('#conditionFilter').val() || $('input[name="conditionToggle"]:checked').val();


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
        $('#mobileResultsCount').text(`${visibleCount} Results`);

        $('#noResults').toggle(visibleCount === 0);
    }
    
    // Bind filter events
    $('#categoryFilter, #brandFilter, #modelFilter, #yearFilter, #mileageFilter, #priceFilter').on('change', filterCars);
    $('#electricOnly, #electricOnlyMobile').on('change', function() {
        $('#electricOnly, #electricOnlyMobile').prop('checked', $(this).is(':checked'));
        filterCars();
    });
    $('input[name="conditionToggle"]').on('change', filterCars);
    
    // Reset filters
    $('#resetFilters, #resetFiltersMobile').on('click', function() {
        $('#brandFilter').val('');
        $('#modelFilter').val('');
        $('#yearFilter').val('');
        $('#mileageFilter').val('');
        $('#conditionFilter').val('');
        $('input[name="conditionToggle"][value=""]').prop('checked', true);
        $('#priceFilter').val('');
        $('#locationFilter').val('');
        $('#electricOnly, #electricOnlyMobile').prop('checked', false);
        filterCars();
    });
    

    // Dependent Dropdowns Logic
    $('#brandFilter').on('change', function() {
        const selectedBrand = $(this).val();
        const modelSelect = $('#modelFilter');
        
        // Reset model selection
        modelSelect.val('').prop('disabled', true).addClass("text-danger").removeClass("text-white")
        .html('<option value="">Select Brand First</option>');
        
        if (selectedBrand) {
            // Enable select and update placeholder
            modelSelect.prop('disabled', false).addClass("text-white").removeClass("text-danger").html('<option value="";>Any</option>');
            
            // Get unique models for selected brand
            const models = new Set();
            cars.forEach(car => {
                if (car.brand.toLowerCase() === selectedBrand) {
                    models.add(car.model);
                }
            });
            
            // Sort and append options
            Array.from(models).sort().forEach(model => {
                modelSelect.append(`<option value="${model.toLowerCase()}">${model}</option>`);
            });
        }
        
        // Trigger filter
        filterCars();
    });

});
</script>
@endsection