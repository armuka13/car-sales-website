@extends('layouts.app')
@section('title', $settings->name)

@section('content')
<div class="contact-bar">
    <div class="container">
        <div class="row text-center align-items-center justify-content-center">
            <div class="col-auto">
                <i class="fas fa-envelope"></i> {{ __('Email') }}: 
                <a href="mailto:{{ $settings->email }}" class="text-white text-decoration-none">
                    <strong>{{ $settings->email }}</strong>
                </a>
            </div>
            <div class="col-auto">
                <i class="fas fa-phone"></i> {{ __('Phone') }}: 
                <a href="tel:{{ $settings->phone }}" class="text-white text-decoration-none">
                    <strong>{{ $settings->phone }}</strong>
                </a>
            </div>
            <div class="col-auto">
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings->phone) }}?text={{ urlencode('Hi, I\'m interested in') }}" 
                    class="btn btn-success btn-sm" 
                    target="_blank">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>  

<div class="hero" style="background-image: url('{{ asset('storage/' . $settings->image) }}');">
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h1 class="display-4 mb-3" style="font-weight:1000">{{ $settings->description }}</h1>
    </div>
</div>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-md-12">
            
            
            @php
                $filterParams = ['category', 'brand', 'model', 'year', 'mileage', 'price', 'condition', 'fuel'];
                $isFiltered = false;
                foreach($filterParams as $param) {
                    if (request()->filled($param)) {
                        $isFiltered = true;
                        break;
                    }
                }
            @endphp

            <div class=" {{ $isFiltered ? 'show' : '' }} d-md-block">
                <form action="{{ route('home') }}" method="GET" id="filterForm">
                <div class="card bg-dark text-white p-4 mb-4">
                <div class="row g-3">


                    <!-- Category -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Category') }}</label>
                        <select id="categoryFilter" name="category" class="form-select custom-input">
                            <option value="">{{ __('Any') }}</option>
                            @foreach($allCars->unique('category')->pluck('category') as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Brand -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Brand') }}</label>
                        <select id="brandFilter" name="brand" class="form-select custom-input">
                            <option value="">{{ __('Any') }}</option>
                            @foreach($allCars->unique('brand')->pluck('brand') as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Model -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Model') }}</label>
                        <select id="modelFilter" name="model" class="form-select custom-input {{ request('model') ? 'text-white' : 'text-danger bg-dark' }}" {{ request('model') ? '' : 'disabled' }}>
                            <option value="">{{ request('model') ? __('Any') : __('Select Brand First') }}</option>
                            @if(request('brand'))
                                @foreach($allCars->filter(fn($c) => $c->brand === request('brand'))->unique('model')->pluck('model') as $model)
                                    <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <!-- First Registration -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Year from') }}</label>
                        <select id="yearFilter" name="year" class="form-select custom-input">
                            <option value="">{{ __('Any') }}</option>
                            @for($year = date('Y'); $year >= 1990; $year--)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <!-- Mileage Up To -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Mileage Up To') }}</label>
                        <select id="mileageFilter" name="mileage" class="form-select custom-input">
                            <option value="">{{ __('Any') }}</option>
                            <option value="50000" {{ request('mileage') == '50000' ? 'selected' : '' }}>50,000 km</option>
                            <option value="100000" {{ request('mileage') == '100000' ? 'selected' : '' }}>100,000 km</option>
                            <option value="150000" {{ request('mileage') == '150000' ? 'selected' : '' }}>150,000 km</option>
                            <option value="200000" {{ request('mileage') == '200000' ? 'selected' : '' }}>200,000 km</option>
                        </select>
                    </div>

                     <!-- Price Up To -->
                    <div class="col-6 col-md-3">
                        <label class="form-label small">{{ __('Price Up To') }}</label>
                        <select id="priceFilter" name="price" class="form-select custom-input">
                            <option value="">{{ __('Any') }}</option>
                            <option value="5000" {{ request('price') == '5000' ? 'selected' : '' }}>{{ __('5,000 €') }}</option>
                            <option value="10000" {{ request('price') == '10000' ? 'selected' : '' }}>{{ __('10,000 €') }}</option>
                            <option value="20000" {{ request('price') == '20000' ? 'selected' : '' }}>{{ __('20,000 €') }}</option>
                            <option value="30000" {{ request('price') == '30000' ? 'selected' : '' }}>{{ __('30,000 €') }}</option>
                            <option value="50000" {{ request('price') == '50000' ? 'selected' : '' }}>{{ __('50,000 €') }}</option>
                            <option value="75000" {{ request('price') == '75000' ? 'selected' : '' }}>{{ __('75,000 €') }}</option>
                            <option value="100000" {{ request('price') == '100000' ? 'selected' : '' }}>{{ __('100,000 €') }}</option>
                        </select>
                    </div>
                    
                    <!-- Condition (Custom Toggle + Sync) -->
                    <div class="col-12 col-md-3">
                        <label class="form-label small">{{ __('Condition') }}</label>
                        <div class="payment-toggle-container d-md-none">
                             <input type="radio" class="btn-check condition-radio" name="condition" id="conditionAny" value="" {{ request('condition') == '' ? 'checked' : '' }}>
                             <label class="btn btn-outline-custom w-33" for="conditionAny">{{ __('Any') }}</label>

                             <input type="radio" class="btn-check condition-radio" name="condition" id="conditionNew" value="new" {{ request('condition') == 'new' ? 'checked' : '' }}>
                             <label class="btn btn-outline-custom w-33" for="conditionNew">{{ __('New') }}</label>

                             <input type="radio" class="btn-check condition-radio" name="condition" id="conditionUsed" value="used" {{ request('condition') == 'used' ? 'checked' : '' }}>
                             <label class="btn btn-outline-custom w-33" for="conditionUsed">{{ __('Used') }}</label>
                        </div>
                        <select id="conditionFilter" name="condition" class="form-select custom-input d-none d-md-block">
                            <option value="">{{ __('Any') }}</option>
                            <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>{{ __('New') }}</option>
                            <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>{{ __('Used') }}</option>
                        </select>
                    </div>

                    <!-- Search Button -->
                    <div class="col-12 col-md-3 d-flex align-items-end">
                        <button type="submit" id="searchBtn" class="btn btn-orange w-100" style="padding: 10px;">
                            <i class="fas fa-search me-2"></i>{{ __('Search') }} (<span id="searchBtnCount">{{ $cars->total() }}</span>)
                        </button>
                    </div>
                    
                   
                    
                    <!-- Additional Filters Toggle (Mobile) -->
                    <div class="col-12 d-block d-md-none mt-3">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="fuel" value="electric" id="electricOnlyMobile" {{ request('fuel') == 'electric' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="electricOnlyMobile">
                                        {{ __('Electric Only') }} <i class="fas fa-charging-station"></i>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-6 d-flex align-items-center justify-content-end">
                                <button type="button" id="resetFiltersMobile" class="btn btn-link text-orange text-decoration-none small p-0" title="{{ __('Reset Filters') }}">
                                    <i class="fas fa-undo me-1"></i> {{ __('Reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                
                    <!-- Electric Only & Reset (Desktop) - Same Row -->
                    <div class="col-12 d-none d-md-flex align-items-center justify-content-between mt-3">
                        <div class="form-check custom-checkbox">
                            <input class="form-check-input" type="checkbox" name="fuel" value="electric" id="electricOnly" {{ request('fuel') == 'electric' ? 'checked' : '' }}>
                            <label class="form-check-label" for="electricOnly">
                                {{ __('Electric Only') }} <i class="fas fa-charging-station ms-1"></i>
                            </label>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <button type="button" id="resetFilters" class="btn btn-link text-orange text-decoration-none small p-0" title="{{ __('Reset Filters') }}">
                                <i class="fas fa-undo me-1"></i> {{ __('Reset Filters') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
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

                /* Premium UI Enhancements */
                .section-header {
                    font-weight: 700;
                    letter-spacing: -0.5px;
                    border-left: 5px solid #e54b18;
                    padding-left: 15px;
                    margin-bottom: 25px;
                }
                
                .horizontal-scroll-wrapper {
                    overflow-x: auto;
                    display: flex;
                    gap: 20px;
                    padding: 10px 0 25px 0;
                    scrollbar-width: thin;
                    scrollbar-color: #e54b18 #212529;
                }
                
                .horizontal-scroll-wrapper::-webkit-scrollbar {
                    height: 6px;
                }
                
                .horizontal-scroll-wrapper::-webkit-scrollbar-thumb {
                    background: #e54b18;
                    border-radius: 10px;
                }
                
                .horizontal-scroll-wrapper .car-item-horizontal {
                    flex: 0 0 320px;
                }
                
                .car-card {
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
                    overflow: hidden;
                    backdrop-filter: blur(10px);
                    background: rgba(33, 37, 41, 0.8) !important;
                }
                
                .car-card:hover {
                    transform: translateY(-10px);
                    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
                    border-color: rgba(229, 75, 24, 0.5);
                }
                
                .car-card .car-image {
                    height: 200px;
                    object-fit: cover;
                    transition: transform 0.6s ease;
                }
                
                .car-card:hover .car-image {
                    transform: scale(1.1);
                }
                
                .price-tag {
                    font-size: 1.5rem;
                    font-weight: 800;
                    color: #fff;
                    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
                }
                
                .badge-premium {
                    background: rgba(229, 75, 24, 0.2);
                    color: #e54b18;
                    border: 1px solid rgba(229, 75, 24, 0.3);
                    font-weight: 600;
                    padding: 5px 10px;
                }
                /* Pagination Styling (compact, responsive) */
                .pagination {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                    padding: 0;
                    margin: 0;
                    list-style: none;
                }
                .page-item .page-link {
                    background-color: #212529 !important;
                    border: 1px solid rgba(255, 255, 255, 0.06) !important;
                    color: rgba(255, 255, 255, 0.85) !important;
                    padding: 6px 10px;
                    font-size: 0.9rem;
                    border-radius: 6px !important;
                    transition: all 0.18s ease;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-width: 38px;
                }
                .page-item.active .page-link {
                    background-color: #e54b18 !important;
                    border-color: #e54b18 !important;
                    color: #fff !important;
                    box-shadow: 0 6px 18px rgba(229, 75, 24, 0.18);
                }
                .page-item.disabled .page-link {
                    background-color: rgba(255, 255, 255, 0.03) !important;
                    color: rgba(255, 255, 255, 0.35) !important;
                    pointer-events: none;
                }
                .page-link:hover:not(.active) {
                    background-color: rgba(229, 75, 24, 0.08) !important;
                    border-color: #e54b18 !important;
                    color: #e54b18 !important;
                }

                /* Fix massive SVG icons in default pagination */
                .pagination svg {
                    width: 1rem !important;
                    height: 1rem !important;
                    display: inline-block;
                }
                
                @media (max-width: 768px) {
                    .car-item {
                        padding: 5px;
                    }
                    .car-card .car-image {
                        height: 130px;
                    }
                    .card-body {
                        padding: 10px;
                    }
                    .card-title {
                        font-size: 0.9rem;
                        margin-bottom: 5px;
                    }
                    .price-tag {
                        font-size: 1.1rem;
                    }
                    .badge-premium {
                        padding: 3px 6px;
                        font-size: 0.7rem;
                    }
                    .btn-primary {
                        padding: 5px;
                        font-size: 0.8rem;
                    }
                    .horizontal-scroll-wrapper .car-item-horizontal {
                        flex: 0 0 200px;
                    }
                }
                
            </style>
        </div>
    </div>
            @if(!$isFiltered)
            <div id="recentlyViewedSection" style="display: none;" class="mb-5">
                <h3 class="section-header text-white">{{ __('Recently Viewed') }}</h3>
                <div id="recentlyViewedContainer" class="horizontal-scroll-wrapper">
                    <!-- Recently viewed cars will be injected here -->
                </div>
            </div>

            <div id="topDealsSection" class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h3 class="section-header text-white">{{ __('Top Deals') }}</h3>
                    <span class="text-orange small">{{ __('Hot picks for you') }}</span>
                </div>
                <div class="horizontal-scroll-wrapper">
                    @php
                        $topDeals = $allCars->sortBy('price')->take(6);
                    @endphp
                    @foreach($topDeals as $deal)
                    <div class="car-item-horizontal">
                        <div class="card car-card h-100">
                            <div class="position-absolute top-0 end-0 m-2 z-index-1">
                                <span class="badge bg-danger">{{ __('HOT DEAL') }}</span>
                            </div>
                            <img src="{{ Str::startsWith($deal->image, 'http') ? $deal->image : asset('storage/' . $deal->image) }}" class="card-img-top car-image" alt="{{ $deal->brand }}">
                            <div class="card-body">
                                <h6 class="text-white mb-1">{{ $deal->brand }} {{ $deal->model }}</h6>
                                <p class="price-tag mb-0">{{ number_format($deal->price) }} €</p>
                                <a href="{{ route('cars.show', $deal->id) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <h2 class="section-header text-orange">{{ $isFiltered ? __('Search Results') : __('Available Cars') }}</h2>

    <div class="row g-2" id="carsContainer">
        @include('partials.cars-grid', ['cars' => $cars])
    </div>
    
    <div id="noResults" class="alert alert-warning text-center" style="{{ $cars->isEmpty() ? '' : 'display: none;' }}">
        <i class="fas fa-search"></i> {{ __('No cars found matching your criteria.') }}
    </div>
    <div class="d-flex justify-content-center mt-5 mb-4" id="paginationContainer">
        {{ $cars->appends(request()->query())->links('pagination::bootstrap-5') }}
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
    
    // Filter count logic (AJAX)
    function updateSearchCount() {
        const formData = $('#filterForm').serialize();
        const searchBtnCount = $('#searchBtnCount');
        
        $.get('{{ route('cars.count') }}?' + formData, function(data) {
            searchBtnCount.text(data.count);
        });
    }

    // Check if any filters are active
    function hasActiveFilters() {
        const formData = new FormData($('#filterForm')[0]);
        for (let [key, value] of formData.entries()) {
            if (value !== '') {
                return true;
            }
        }
        return false;
    }

    // AJAX Search Handler
    $('#filterForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const carsContainer = $('#carsContainer');
        const paginationContainer = $('#paginationContainer');
        const searchBtnCount = $('#searchBtnCount');
        
        $.ajax({
            url: '{{ route('cars.search') }}',
            method: 'GET',
            data: formData,
            success: function(response) {
                // Update cars grid
                carsContainer.html(response.html);
                
                // Update pagination
                paginationContainer.html(response.pagination);
                
                // Update search button count
                searchBtnCount.text(response.total);
                
                // Hide recently viewed and top deals when filters are active
                if (hasActiveFilters()) {
                    $('#recentlyViewedSection, #topDealsSection').fadeOut();
                }
                
                // Scroll to results
                $('html, body').animate({
                    scrollTop: carsContainer.offset().top - 100
                }, 600);
            },
            error: function() {
                alert('{{ __('An error occurred while searching. Please try again.') }}');
            }
        });
    });

    // Bind filter events for real-time count + instant hiding
    $('#categoryFilter, #brandFilter, #modelFilter, #yearFilter, #mileageFilter, #priceFilter, #conditionFilter, .condition-radio, #electricOnly, #electricOnlyMobile').on('change', function() {
        updateSearchCount();
        
        // Hide recently viewed and top deals when filters are active
        if (hasActiveFilters()) {
            $('#recentlyViewedSection, #topDealsSection').fadeOut();
        } else {
            $('#recentlyViewedSection, #topDealsSection').fadeIn();
        }
    });

    // Electric Only Sync Logic
    $('#electricOnly, #electricOnlyMobile').on('change', function() {
        $('#electricOnly, #electricOnlyMobile').prop('checked', $(this).is(':checked'));
    });

    // Condition Sync Logic - now both radio and select have name="condition"
    const conditionRadios = $('.condition-radio');
    const conditionSelect = $('#conditionFilter');

    conditionRadios.on('change', function() {
        const val = $(this).val();
        conditionSelect.val(val);
    });

    conditionSelect.on('change', function() {
        const val = $(this).val();
        conditionRadios.filter(`[value="${val}"]`).prop('checked', true);
    });

    // Reset filters - now triggers AJAX search
    $('#resetFilters, #resetFiltersMobile').on('click', function(e) {
        e.preventDefault();
        
        // Reset all select dropdowns
        $('#categoryFilter, #brandFilter, #yearFilter, #mileageFilter, #priceFilter, #conditionFilter').val('');
        
        // Reset and disable model dropdown
        $('#modelFilter').val('').prop('disabled', true).addClass("text-danger").removeClass("text-white")
            .html('<option value="">Select Brand First</option>');
        
        // Reset condition radios
        $('#conditionAny').prop('checked', true);
        
        // Reset electric checkboxes
        $('#electricOnly, #electricOnlyMobile').prop('checked', false);
        
        // Show Recently Viewed and Top Deals sections
        $('#recentlyViewedSection, #topDealsSection').fadeIn();
        
        // Update the search count first
        updateSearchCount();
        
        // Trigger form submission to reload all cars
        $('#filterForm').submit();
    });
    

    // Dependent Dropdowns Logic - FIXED brand/model comparison
    $('#brandFilter').on('change', function() {
        const selectedBrand = $(this).val();
        const modelSelect = $('#modelFilter');
        
        // Reset model selection
        modelSelect.val('').prop('disabled', true).addClass("text-danger").removeClass("text-white")
        .html('<option value="">Select Brand First</option>');
        
        if (selectedBrand) {
            // Enable select and update placeholder
            modelSelect.prop('disabled', false).addClass("text-white").removeClass("text-danger").html('<option value="">Any</option>');
            
            // Get unique models for selected brand from the allCars collection
            const models = new Set();
            @json($allCars).forEach(car => {
                // Fixed: Direct comparison without toLowerCase since we removed it from the select options
                if (car.brand === selectedBrand) {
                    models.add(car.model);
                }
            });
            
            // Sort and append options
            Array.from(models).sort().forEach(model => {
                modelSelect.append(`<option value="${model}">${model}</option>`);
            });
        }
    });

    // Handle pagination link clicks
    $(document).on('click', '.pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        
        // Extract page number from URL
        const pageParam = new URL(url).searchParams.get('page');
        
        // Add page to form data
        const formData = $('#filterForm').serialize() + '&page=' + pageParam;
        const carsContainer = $('#carsContainer');
        const paginationContainer = $('#paginationContainer');
        
        $.ajax({
            url: '{{ route('cars.search') }}',
            method: 'GET',
            data: formData,
            success: function(response) {
                // Update cars grid
                carsContainer.html(response.html);
                
                // Update pagination
                paginationContainer.html(response.pagination);
                
                // Scroll to results
                $('html, body').animate({
                    scrollTop: carsContainer.offset().top - 100
                }, 600);
            },
            error: function() {
                alert('{{ __('An error occurred while loading the page. Please try again.') }}');
            }
        });
    });

    // Recently Viewed Logic
    const recentlyViewedIds = JSON.parse(localStorage.getItem('recentlyViewed') || '[]');
    if (recentlyViewedIds.length > 0 && !@json($isFiltered)) {
        const viewedContainer = $('#recentlyViewedContainer');
        const viewedSection = $('#recentlyViewedSection');
        
        recentlyViewedIds.forEach(id => {
            const car = @json($allCars).find(c => c.id == id);
            if (car) {
                const imagePath = (car.image && car.image.startsWith('http')) 
                    ? car.image 
                    : `/storage/${car.image}`;
                
                const carHtml = `
                    <div class="car-item-horizontal">
                        <div class="card car-card h-100">
                            <img src="${imagePath}" class="card-img-top car-image" alt="${car.brand}">
                            <div class="card-body">
                                <h6 class="text-white mb-1">${car.brand} ${car.model}</h6>
                                <p class="price-tag mb-0">${Number(car.price).toLocaleString()} €</p>
                                <a href="/cars/${car.id}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                `;
                viewedContainer.append(carHtml);
            }
        });
        
        if (viewedContainer.children().length > 0) {
            viewedSection.fadeIn();
        }
    }
});
</script>
@endsection