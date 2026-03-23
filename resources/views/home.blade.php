@extends('layouts.app')
@section('title', $settings->name)

@section('content')
<div style="padding-top: 70px;"></div>


<div class="hero" style="background-image: url('{{ asset('storage/' . $settings->image) }}');">
    <div class="container hero-content">
        <h1 class="display-4 mb-3" style="font-weight: 900; letter-spacing: -1px;">{{ $settings->description }}</h1>
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

            <div class="{{ $isFiltered ? 'show' : '' }} d-md-block">
                <form action="{{ route('home') }}" method="GET" id="filterForm">
                    <div class="filter-card p-4 mb-4">
                        <div class="row g-3">

                            <!-- Category -->
                            <div class="col-6 col-md-3">
                                <label class="form-label small">{{ __('Category') }}</label>
                                <select id="categoryFilter" name="category" class="form-select custom-input">
                                    <option value="">{{ __('Any') }}</option>
                                    @foreach($allCars->unique('category')->pluck('category') as $category)
                                    <option value="{{ $category }}" {{ request('category')==$category ? 'selected' : ''
                                        }}>{{ $category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Brand -->
                            <div class="col-6 col-md-3">
                                <label class="form-label small">{{ __('Brand') }}</label>
                                <select id="brandFilter" name="brand" class="form-select custom-input">
                                    <option value="">{{ __('Any') }}</option>
                                    @foreach($allCars->unique('brand')->pluck('brand') as $brand)
                                    <option value="{{ $brand }}" {{ request('brand')==$brand ? 'selected' : '' }}>{{
                                        $brand }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Model -->
                            <div class="col-6 col-md-3">
                                <label class="form-label small">{{ __('Model') }}</label>
                                <select id="modelFilter" name="model"
                                    class="form-select custom-input {{ request('model') ? 'text-white' : 'text-muted' }}"
                                    {{ request('model') ? '' : 'disabled' }}>
                                    <option value="">{{ request('model') ? __('Any') : __('Select Brand First') }}
                                    </option>
                                    @if(request('brand'))
                                    @foreach($allCars->filter(fn($c) => $c->brand ===
                                    request('brand'))->unique('model')->pluck('model') as $model)
                                    <option value="{{ $model }}" {{ request('model')==$model ? 'selected' : '' }}>{{
                                        $model }}</option>
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
                                    <option value="{{ $year }}" {{ request('year')==$year ? 'selected' : '' }}>{{ $year
                                        }}</option>
                                    @endfor
                                </select>
                            </div>

                            <!-- Mileage Up To -->
                            <div class="col-6 col-md-3">
                                <label class="form-label small">{{ __('Mileage Up To') }}</label>
                                <select id="mileageFilter" name="mileage" class="form-select custom-input">
                                    <option value="">{{ __('Any') }}</option>
                                    <option value="50000" {{ request('mileage')=='50000' ? 'selected' : '' }}>50,000 km
                                    </option>
                                    <option value="100000" {{ request('mileage')=='100000' ? 'selected' : '' }}>100,000
                                        km</option>
                                    <option value="150000" {{ request('mileage')=='150000' ? 'selected' : '' }}>150,000
                                        km</option>
                                    <option value="200000" {{ request('mileage')=='200000' ? 'selected' : '' }}>200,000
                                        km</option>
                                </select>
                            </div>

                            <!-- Price Up To -->
                            <div class="col-6 col-md-3">
                                <label class="form-label small">{{ __('Price Up To') }}</label>
                                <select id="priceFilter" name="price" class="form-select custom-input">
                                    <option value="">{{ __('Any') }}</option>
                                    <option value="5000" {{ request('price')=='5000' ? 'selected' : '' }}>{{ __('5,000
                                        €') }}</option>
                                    <option value="10000" {{ request('price')=='10000' ? 'selected' : '' }}>{{
                                        __('10,000 €') }}</option>
                                    <option value="20000" {{ request('price')=='20000' ? 'selected' : '' }}>{{
                                        __('20,000 €') }}</option>
                                    <option value="30000" {{ request('price')=='30000' ? 'selected' : '' }}>{{
                                        __('30,000 €') }}</option>
                                    <option value="50000" {{ request('price')=='50000' ? 'selected' : '' }}>{{
                                        __('50,000 €') }}</option>
                                    <option value="75000" {{ request('price')=='75000' ? 'selected' : '' }}>{{
                                        __('75,000 €') }}</option>
                                    <option value="100000" {{ request('price')=='100000' ? 'selected' : '' }}>{{
                                        __('100,000 €') }}</option>
                                </select>
                            </div>

                            <!-- Condition (Custom Toggle + Sync) -->
                            <div class="col-12 col-md-3">
                                <label class="form-label small">{{ __('Condition') }}</label>
                                <div class="payment-toggle-container d-md-none">
                                    <input type="radio" class="btn-check condition-radio" name="condition"
                                        id="conditionAny" value="" {{ request('condition')=='' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-custom w-33" for="conditionAny">{{ __('Any')
                                        }}</label>

                                    <input type="radio" class="btn-check condition-radio" name="condition"
                                        id="conditionNew" value="new" {{ request('condition')=='new' ? 'checked' : ''
                                        }}>
                                    <label class="btn btn-outline-custom w-33" for="conditionNew">{{ __('New')
                                        }}</label>

                                    <input type="radio" class="btn-check condition-radio" name="condition"
                                        id="conditionUsed" value="used" {{ request('condition')=='used' ? 'checked' : ''
                                        }}>
                                    <label class="btn btn-outline-custom w-33" for="conditionUsed">{{ __('Used')
                                        }}</label>
                                </div>
                                <select id="conditionFilter" name="condition"
                                    class="form-select custom-input d-none d-md-block">
                                    <option value="">{{ __('Any') }}</option>
                                    <option value="new" {{ request('condition')=='new' ? 'selected' : '' }}>{{ __('New')
                                        }}</option>
                                    <option value="used" {{ request('condition')=='used' ? 'selected' : '' }}>{{
                                        __('Used') }}</option>
                                </select>
                            </div>

                            <!-- Search Button -->
                            <div class="col-12 col-md-3 d-flex align-items-end">
                                <button type="submit" id="searchBtn" class="btn search-btn w-100">
                                    <i class="fas fa-search me-2"></i>{{ __('Search') }} (<span id="searchBtnCount">{{
                                        $cars->total() }}</span>)
                                </button>
                            </div>

                            <!-- Additional Filters Toggle (Mobile) -->
                            <div class="col-12 d-block d-md-none mt-3">
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <div class="form-check custom-checkbox">
                                            <input class="form-check-input" type="checkbox" name="fuel" value="electric"
                                                id="electricOnlyMobile" {{ request('fuel')=='electric' ? 'checked' : ''
                                                }}>
                                            <label class="form-check-label" for="electricOnlyMobile">
                                                {{ __('Electric Only') }} <i class="fas fa-charging-station"></i>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col-6 d-flex align-items-center justify-content-end">
                                        <button type="button" id="resetFiltersMobile"
                                            class="btn btn-link text-color text-decoration-none small p-0"
                                            title="{{ __('Reset Filters') }}">
                                            <i class="fas fa-undo me-1"></i> {{ __('Reset') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Electric Only & Reset (Desktop) - Same Row -->
                            <div class="col-12 d-none d-md-flex align-items-center justify-content-between mt-3">
                                <div class="form-check custom-checkbox">
                                    <input class="form-check-input" type="checkbox" name="fuel" value="electric"
                                        id="electricOnly" {{ request('fuel')=='electric' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="electricOnly">
                                        {{ __('Electric Only') }} <i class="fas fa-charging-station ms-1"></i>
                                    </label>
                                </div>

                                <div class="d-flex align-items-center">
                                    <button type="button" id="resetFilters"
                                        class="btn btn-link text-color text-decoration-none small p-0"
                                        title="{{ __('Reset Filters') }}">
                                        <i class="fas fa-undo me-1"></i> {{ __('Reset Filters') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <style>
                /* ===== Filter Card ===== */
                .filter-card {
                    background: rgba(30, 35, 42, 0.85);
                    backdrop-filter: blur(16px);
                    border: 1px solid rgba(255, 255, 255, 0.08);
                    border-radius: 18px;
                    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
                }

                .custom-input {
                    background-color: rgba(20, 24, 30, 0.8);
                    border: 1px solid rgba(255, 255, 255, 0.1);
                    color: white;
                    border-radius: 10px;
                    padding: 10px 14px;
                    font-size: 0.9rem;
                    transition: all 0.3s ease;
                }

                .custom-input:focus {
                    background-color: rgba(25, 30, 38, 0.9);
                    color: white;
                    border-color: rgba(120, 229, 24, 0.5);
                    box-shadow: 0 0 0 3px rgba(120, 229, 24, 0.1), 0 0 20px rgba(120, 229, 24, 0.08);
                }

                .text-color {
                    color: #78e518;
                }

                .text-color:hover {
                    color: #8fff2e;
                }

                /* ===== Condition Toggle ===== */
                .payment-toggle-container {
                    display: flex;
                    background-color: rgba(20, 24, 30, 0.8);
                    border-radius: 10px;
                    padding: 3px;
                    border: 1px solid rgba(255, 255, 255, 0.1);
                }

                .btn-outline-custom {
                    color: #adb5bd;
                    border: none;
                    flex: 1;
                    padding: 8px 0;
                    font-size: 0.88rem;
                    border-radius: 8px;
                    transition: all 0.25s ease;
                }

                .btn-check:checked+.btn-outline-custom {
                    background: rgba(120, 229, 24, 0.12);
                    color: #78e518;
                    border: 1px solid rgba(120, 229, 24, 0.3);
                }

                /* ===== Search Button ===== */
                .search-btn {
                    background: linear-gradient(135deg, #5cb510, #3d8a08);
                    color: white;
                    border: none;
                    font-size: 1rem;
                    font-weight: 600;
                    padding: 11px 20px;
                    border-radius: 10px;
                    transition: all 0.3s ease;
                    box-shadow: 0 4px 15px rgba(92, 181, 16, 0.25);
                    position: relative;
                    overflow: hidden;
                }

                .search-btn::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: -100%;
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
                    transition: left 0.5s ease;
                }

                .search-btn:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 8px 25px rgba(92, 181, 16, 0.4);
                    color: white;
                }

                .search-btn:hover::before {
                    left: 100%;
                }

                /* ===== Checkbox ===== */
                .custom-checkbox .form-check-input {
                    background-color: transparent;
                    border: 1.5px solid rgba(255, 255, 255, 0.3);
                    width: 20px;
                    height: 20px;
                    border-radius: 6px;
                    transition: all 0.2s ease;
                }

                .custom-checkbox .form-check-input:checked {
                    background-color: #78e518;
                    border-color: #78e518;
                }

                .form-label {
                    font-weight: 500;
                    color: rgba(255, 255, 255, 0.65);
                    font-size: 0.82rem;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-bottom: 6px;
                }

                /* ===== Section Headers ===== */
                .section-header {
                    font-weight: 800;
                    letter-spacing: -0.5px;
                    padding-left: 18px;
                    margin-bottom: 25px;
                    position: relative;
                }

                .section-header::before {
                    content: '';
                    position: absolute;
                    left: 0;
                    top: 4px;
                    bottom: 4px;
                    width: 4px;
                    border-radius: 4px;
                    background: linear-gradient(180deg, #78e518, #4db800);
                }

                /* ===== Horizontal Scroll ===== */
                .horizontal-scroll-wrapper {
                    overflow-x: auto;
                    display: flex;
                    gap: 20px;
                    padding: 10px 0 25px 0;
                    scrollbar-width: thin;
                    scrollbar-color: #3d8a08 rgba(30, 35, 42, 0.5);
                }

                .horizontal-scroll-wrapper::-webkit-scrollbar {
                    height: 6px;
                }

                .horizontal-scroll-wrapper::-webkit-scrollbar-track {
                    background: rgba(30, 35, 42, 0.5);
                    border-radius: 10px;
                }

                .horizontal-scroll-wrapper::-webkit-scrollbar-thumb {
                    background: linear-gradient(90deg, #78e518, #4db800);
                    border-radius: 10px;
                }

                .horizontal-scroll-wrapper .car-item-horizontal {
                    flex: 0 0 320px;
                }

                /* ===== Hot Deal Badge ===== */
                .hot-deal-badge {
                    background: linear-gradient(135deg, #ff4757, #ff6b81);
                    font-size: 0.72rem;
                    font-weight: 700;
                    padding: 5px 12px;
                    border-radius: 8px;
                    letter-spacing: 0.5px;
                    animation: pulseGlow 2s infinite;
                }

                @keyframes pulseGlow {

                    0%,
                    100% {
                        box-shadow: 0 0 8px rgba(255, 71, 87, 0.3);
                    }

                    50% {
                        box-shadow: 0 0 20px rgba(255, 71, 87, 0.6);
                    }
                }

                /* ===== Car Grid Cards ===== */
                .car-card .card-img-wrapper {
                    overflow: hidden;
                    position: relative;
                    border-radius: 14px 14px 0 0;
                }

                .car-card .card-img-wrapper .car-image-overlay {
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

                /* ===== Pagination ===== */
                .pagination {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                    padding: 0;
                    margin: 0;
                    list-style: none;
                }

                .page-item .page-link {
                    background-color: rgba(30, 35, 42, 0.8) !important;
                    border: 1px solid rgba(255, 255, 255, 0.06) !important;
                    color: rgba(255, 255, 255, 0.8) !important;
                    padding: 8px 12px;
                    font-size: 0.88rem;
                    border-radius: 10px !important;
                    transition: all 0.25s ease;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    min-width: 40px;
                    font-weight: 500;
                }

                .page-item.active .page-link {
                    background: linear-gradient(135deg, #5cb510, #3d8a08) !important;
                    border-color: transparent !important;
                    color: #fff !important;
                    box-shadow: 0 4px 15px rgba(92, 181, 16, 0.3);
                }

                .page-item.disabled .page-link {
                    background-color: rgba(255, 255, 255, 0.03) !important;
                    color: rgba(255, 255, 255, 0.25) !important;
                    pointer-events: none;
                }

                .page-link:hover:not(.active) {
                    background-color: rgba(120, 229, 24, 0.1) !important;
                    border-color: rgba(120, 229, 24, 0.3) !important;
                    color: #78e518 !important;
                }

                .pagination svg {
                    width: 1rem !important;
                    height: 1rem !important;
                    display: inline-block;
                }

                /* ===== Stagger Animation ===== */
                .car-item {
                    animation: cardFadeIn 0.5s ease forwards;
                    opacity: 0;
                }

                .car-item:nth-child(1) {
                    animation-delay: 0.05s;
                }

                .car-item:nth-child(2) {
                    animation-delay: 0.1s;
                }

                .car-item:nth-child(3) {
                    animation-delay: 0.15s;
                }

                .car-item:nth-child(4) {
                    animation-delay: 0.2s;
                }

                .car-item:nth-child(5) {
                    animation-delay: 0.25s;
                }

                .car-item:nth-child(6) {
                    animation-delay: 0.3s;
                }

                .car-item:nth-child(7) {
                    animation-delay: 0.35s;
                }

                .car-item:nth-child(8) {
                    animation-delay: 0.4s;
                }

                .car-item:nth-child(9) {
                    animation-delay: 0.45s;
                }

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

                @media (max-width: 768px) {
                    .car-item {
                        padding: 4px;
                    }

                    .horizontal-scroll-wrapper .car-item-horizontal {
                        flex: 0 0 220px;
                    }

                    .filter-card {
                        border-radius: 14px;
                        padding: 16px !important;
                    }
                }
            </style>
        </div>
    </div>
    @if(!$isFiltered)
    <div id="recentlyViewedSection" style="display: none;" class="mb-5 fade-in-up">
        <h3 class="section-header text-white">{{ __('Recently Viewed') }}</h3>
        <div id="recentlyViewedContainer" class="horizontal-scroll-wrapper">
            <!-- Recently viewed cars will be injected here -->
        </div>
    </div>

    <div id="topDealsSection" class="mb-5 fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h3 class="section-header text-white mb-0">{{ __('Top Deals') }}</h3>
            <span class="text-color small" style="opacity: 0.8;"><i class="fas fa-fire me-1"></i>{{ __('Hot picks for
                you') }}</span>
        </div>
        <div class="horizontal-scroll-wrapper">
            @php
            $topDeals = $allCars->sortBy('price')->take(6);
            @endphp
            @foreach($topDeals as $deal)
            <div class="car-item-horizontal">
                <div class="card car-card h-100">
                    <div class="card-img-wrapper">
                        <div class="position-absolute top-0 end-0 m-2" style="z-index: 3;">
                            <span class="badge hot-deal-badge">{{ __('HOT DEAL') }}</span>
                        </div>
                        <img src="{{ Str::startsWith($deal->image, 'http') ? $deal->image : asset('storage/' . $deal->image) }}"
                            class="card-img-top car-image" alt="{{ $deal->brand }}">
                        <div class="car-image-overlay"></div>
                    </div>
                    <div class="card-body">
                        <h6 class="text-white mb-1 fw-semibold">{{ $deal->brand }} {{ $deal->model }}</h6>
                        <p class="price-tag mb-0">{{ number_format($deal->price) }} €</p>
                        <a href="{{ route('cars.show', $deal->id) }}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <h2 class="section-header text-color fade-in-up">{{ $isFiltered ? __('Search Results') : __('Available Cars') }}
    </h2>

    <div class="row g-2" id="carsContainer">
        @include('partials.cars-grid', ['cars' => $cars])
    </div>

    <div id="noResults" class="alert text-center py-4"
        style="background: rgba(255, 193, 7, 0.08); border: 1px solid rgba(255, 193, 7, 0.2); border-radius: 14px; color: #ffc107; {{ $cars->isEmpty() ? '' : 'display: none;' }}">
        <i class="fas fa-search fa-2x mb-2 d-block" style="opacity: 0.5;"></i> {{ __('No cars found matching your
        criteria.') }}
    </div>
    <div class="d-flex justify-content-center mt-5 mb-4" id="paginationContainer">
        {{ $cars->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
</div>


@endsection

@section('scripts')
<script>
    window.addEventListener('scroll', function () {
        const hero = document.querySelector('.hero');
        if (!hero) return;
        const heroTexts = document.querySelectorAll('.hero h1, .hero p');
        const scrolled = window.pageYOffset;
        const heroHeight = hero.offsetHeight;

        const opacity = 1 - (scrolled / heroHeight);
        heroTexts.forEach(function (text) {
            if (opacity >= 0) {
                text.style.opacity = Math.max(opacity, 0);
                text.style.transform = 'translateY(' + (scrolled * 0.3) + 'px)';
            }
        });
    });

    $(document).ready(function () {
        const cars = @json($cars);

        // Filter count logic (AJAX)
        function updateSearchCount() {
            const formData = $('#filterForm').serialize();
            const searchBtnCount = $('#searchBtnCount');

            $.get('{{ route('cars.count') }}?' + formData, function (data) {
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
        $('#filterForm').on('submit', function (e) {
            e.preventDefault();

            const formData = $(this).serialize();
            const carsContainer = $('#carsContainer');
            const paginationContainer = $('#paginationContainer');
            const searchBtnCount = $('#searchBtnCount');

            $.ajax({
                url: '{{ route('cars.search') }}',
                method: 'GET',
                data: formData,
                success: function (response) {
                    carsContainer.html(response.html);
                    paginationContainer.html(response.pagination);
                    searchBtnCount.text(response.total);

                    if (hasActiveFilters()) {
                        $('#recentlyViewedSection, #topDealsSection').fadeOut();
                    }

                    $('html, body').animate({
                        scrollTop: carsContainer.offset().top - 100
                    }, 600);
                },
                error: function () {
                    alert('{{ __('An error occurred while searching.Please try again.') }}');
        }
        });
    });

    // Bind filter events for real-time count
    $('#categoryFilter, #brandFilter, #modelFilter, #yearFilter, #mileageFilter, #priceFilter, #conditionFilter, .condition-radio, #electricOnly, #electricOnlyMobile').on('change', function () {
        updateSearchCount();

        if (hasActiveFilters()) {
            $('#recentlyViewedSection, #topDealsSection').fadeOut();
        } else {
            $('#recentlyViewedSection, #topDealsSection').fadeIn();
        }
    });

    // Electric Only Sync Logic
    $('#electricOnly, #electricOnlyMobile').on('change', function () {
        $('#electricOnly, #electricOnlyMobile').prop('checked', $(this).is(':checked'));
    });

    // Condition Sync Logic
    const conditionRadios = $('.condition-radio');
    const conditionSelect = $('#conditionFilter');

    conditionRadios.on('change', function () {
        const val = $(this).val();
        conditionSelect.val(val);
    });

    conditionSelect.on('change', function () {
        const val = $(this).val();
        conditionRadios.filter(`[value="${val}"]`).prop('checked', true);
    });

    // Reset filters
    $('#resetFilters, #resetFiltersMobile').on('click', function (e) {
        e.preventDefault();

        $('#categoryFilter, #brandFilter, #yearFilter, #mileageFilter, #priceFilter, #conditionFilter').val('');

        $('#modelFilter').val('').prop('disabled', true).addClass("text-muted").removeClass("text-white")
            .html('<option value="">Select Brand First</option>');

        $('#conditionAny').prop('checked', true);
        $('#electricOnly, #electricOnlyMobile').prop('checked', false);

        $('#recentlyViewedSection, #topDealsSection').fadeIn();

        updateSearchCount();
        $('#filterForm').submit();
    });


    // Dependent Dropdowns Logic
    $('#brandFilter').on('change', function () {
        const selectedBrand = $(this).val();
        const modelSelect = $('#modelFilter');

        modelSelect.val('').prop('disabled', true).addClass("text-muted").removeClass("text-white")
            .html('<option value="">Select Brand First</option>');

        if (selectedBrand) {
            modelSelect.prop('disabled', false).addClass("text-white").removeClass("text-muted").html('<option value="">Any</option>');

            const models = new Set();
            @json($allCars).forEach(car => {
                if (car.brand === selectedBrand) {
                    models.add(car.model);
                }
            });

            Array.from(models).sort().forEach(model => {
                modelSelect.append(`<option value="${model}">${model}</option>`);
            });
        }
    });

    // Handle pagination link clicks
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');

        const pageParam = new URL(url).searchParams.get('page');
        const formData = $('#filterForm').serialize() + '&page=' + pageParam;
        const carsContainer = $('#carsContainer');
        const paginationContainer = $('#paginationContainer');

        $.ajax({
            url: '{{ route('cars.search') }}',
            method: 'GET',
            data: formData,
            success: function (response) {
                carsContainer.html(response.html);
                paginationContainer.html(response.pagination);

                $('html, body').animate({
                    scrollTop: carsContainer.offset().top - 100
                }, 600);
            },
            error: function () {
                alert('{{ __('An error occurred while loading the page.Please try again.') }}');
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
                            <div class="card-img-wrapper">
                                <img src="${imagePath}" class="card-img-top car-image" alt="${car.brand}">
                                <div class="car-image-overlay"></div>
                            </div>
                            <div class="card-body">
                                <h6 class="text-white mb-1 fw-semibold">${car.brand} ${car.model}</h6>
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