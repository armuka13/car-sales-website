<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Sales')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/logo.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* ===== Global ===== */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        ::selection {
            background: rgba(120, 229, 24, 0.3);
            color: #fff;
        }

        body {
            font-family: 'Inter', 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: #1a1f25;
            color: #e0e0e0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ===== Navbar ===== */
        .navbar {
            background: rgba(18, 22, 28, 0.75) !important;
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            transition: all 0.4s ease;
            padding: 12px 0;
        }

        .navbar.scrolled {
            background: rgba(12, 15, 19, 0.95) !important;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
            padding: 8px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: -0.5px;
            transition: all 0.3s ease;
        }

        .navbar-brand i {
            background: linear-gradient(135deg, #78e518, #4db800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-right: 6px;
            font-size: 1.3rem;
        }

        .navbar-brand:hover {
            opacity: 0.85;
        }

        .navbar .nav-link {
            font-weight: 500;
            font-size: 0.92rem;
            padding: 8px 16px !important;
            color: rgba(255, 255, 255, 0.75) !important;
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar .nav-link::after {
            content: '';
            position: absolute;
            bottom: 2px;
            left: 16px;
            right: 16px;
            height: 2px;
            background: linear-gradient(90deg, #78e518, #4db800);
            border-radius: 2px;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar .nav-link:hover {
            color: #fff !important;
        }

        .navbar .nav-link:hover::after {
            transform: scaleX(1);
        }

        .lang-switcher .btn {
            border-radius: 8px;
            padding: 4px 8px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
        }

        .lang-switcher .btn:hover,
        .lang-switcher .btn.active {
            border-color: rgba(120, 229, 24, 0.5);
            box-shadow: 0 0 12px rgba(120, 229, 24, 0.15);
        }

        /* ===== Car Cards (Global) ===== */
        .car-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.06);
            background: rgba(30, 35, 42, 0.9) !important;
            position: relative;
        }

        .car-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45), 0 0 20px rgba(120, 229, 24, 0.08);
            border-color: rgba(120, 229, 24, 0.2);
        }

        .car-image {
            height: 220px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.5s ease;
        }

        .car-card:hover .car-image {
            transform: scale(1.06);
        }

        .price-tag {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: -0.5px;
        }

        /* ===== Favorites Button ===== */
        .toggle-favorite {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 10;
            transition: all 0.3s ease;
        }

        .toggle-favorite i {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .toggle-favorite.favorited i {
            color: #ff4757;
            animation: heartPop 0.4s ease;
        }

        @keyframes heartPop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.35);
            }

            100% {
                transform: scale(1);
            }
        }

        .toggle-favorite:hover {
            transform: scale(1.15);
            background: rgba(0, 0, 0, 0.7);
            border-color: rgba(255, 71, 87, 0.4);
        }

        .favorites-badge {
            position: relative;
        }

        #favoritesCount {
            position: absolute;
            top: -2px;
            right: -4px;
            background: linear-gradient(135deg, #ff4757, #ff6b81);
            color: white;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: none;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            padding: 0 4px;
        }

        /* ===== Hero ===== */
        .hero {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 160px 0 140px;
            position: relative;
            min-height: 520px;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg,
                    rgba(10, 12, 16, 0.4) 0%,
                    rgba(10, 12, 16, 0.6) 50%,
                    rgba(26, 31, 37, 1) 100%);
            z-index: 1;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero h1,
        .hero p {
            color: white;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            animation: heroFadeIn 1.2s ease-out;
        }

        @keyframes heroFadeIn {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== Contact Bar ===== */
        .contact-bar {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9));
            backdrop-filter: blur(10px);
            color: white;
            padding: 14px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .contact-bar a {
            transition: opacity 0.2s ease;
        }

        .contact-bar a:hover {
            opacity: 0.8;
        }

        .whatsapp-btn {
            background: linear-gradient(135deg, #25d366, #128c7e);
            border: none;
            border-radius: 10px;
            padding: 8px 18px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .whatsapp-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.45);
            color: white;
        }

        /* ===== Badges ===== */
        .badge-custom {
            padding: 8px 12px;
            border-radius: 20px;
        }

        .badge-premium {
            background: rgba(120, 229, 24, 0.12);
            color: #8fff2e;
            border: 1px solid rgba(120, 229, 24, 0.2);
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
        }

        /* ===== Carousel ===== */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            padding: 20px;
        }

        .carousel-indicators button {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .carousel-indicators button.active {
            background-color: rgba(255, 255, 255, 1);
        }

        .carousel-item img {
            max-height: 500px;
            object-fit: contain;
            width: 100%;
        }

        /* ===== Footer ===== */
        footer {
            background: linear-gradient(180deg, #1a1f25 0%, #12161c 100%);
            color: rgba(255, 255, 255, 0.7);
            padding: 50px 0 30px;
            margin-top: 80px;
            border-top: 1px solid rgba(120, 229, 24, 0.15);
            position: relative;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, #78e518, transparent);
        }

        .footer-brand {
            font-weight: 800;
            font-size: 1.3rem;
            color: #fff;
            margin-bottom: 8px;
        }

        .footer-brand i {
            background: linear-gradient(135deg, #78e518, #4db800);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.55);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: inline-block;
            padding: 4px 0;
        }

        .footer-links a:hover {
            color: #78e518;
            transform: translateX(4px);
        }

        .footer-divider {
            border-color: rgba(255, 255, 255, 0.08);
            margin: 25px 0;
        }

        .footer-bottom {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
        }

        /* ===== Scroll-to-Top ===== */
        .scroll-top-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #78e518, #4db800);
            border: none;
            color: #fff;
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(120, 229, 24, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .scroll-top-btn.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .scroll-top-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 35px rgba(120, 229, 24, 0.5);
        }

        /* ===== Animations ===== */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ===== Responsive ===== */
        @media (max-width: 768px) {
            .hero {
                padding: 100px 0 80px;
                min-height: 400px;
                background-attachment: scroll;
            }

            .car-image {
                height: 160px;
            }

            .card-body {
                padding: 12px;
            }

            .card-title {
                font-size: 0.9rem;
                margin-bottom: 4px;
            }

            .price-tag {
                font-size: 1.15rem;
            }

            .badge-premium {
                padding: 3px 7px;
                font-size: 0.68rem;
            }

            .scroll-top-btn {
                bottom: 20px;
                right: 20px;
                width: 42px;
                height: 42px;
                border-radius: 12px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-car"></i> {{ $settings->name }}
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">{{ __('Home') }}</a>
                    </li>
                    @guest
                    <li class="nav-item favorites-badge">
                        <a class="nav-link" href="{{ route('favorites') }}">
                            <i class="fas fa-heart"></i> {{ __('Favorites') }}
                            <span id="favoritesCount">0</span>
                        </a>
                    </li>
                    @endguest

                    @auth
                    @if(auth()->user()->is_admin)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.settings') }}">{{ __('Settings') }}</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="text-decoration:none;">{{
                                __('Logout') }}</button>
                        </form>
                    </li>
                    @endauth

                    <li class="nav-item ms-lg-3 lang-switcher">
                        <div class="btn-group" role="group" aria-label="Language switcher">
                            <a href="{{ route('locale.switch', ['locale' => 'en']) }}"
                                class="btn btn-sm btn-outline-light {{ app()->getLocale() === 'en' ? 'active' : '' }}"><img
                                    src="{{ asset('images/gb.png') }}" height="20" width="20" alt="EN"></a>
                            <a href="{{ route('locale.switch', ['locale' => 'de']) }}"
                                class="btn btn-sm btn-outline-light {{ app()->getLocale() === 'de' ? 'active' : '' }}"><img
                                    src="{{ asset('images/de.png') }}" height="20" width="20" alt="DE"></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="footer-brand">
                        <i class="fas fa-car"></i> {{ $settings->name }}
                    </div>
                    <p class="small mb-3" style="color: rgba(255,255,255,0.5); max-width: 280px;">
                        {{ __('Quality vehicles, transparent pricing, and exceptional service.') }}
                    </p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0 footer-links">
                    <h6 class="text-uppercase mb-3"
                        style="font-size: 0.8rem; letter-spacing: 1.5px; color: rgba(255,255,255,0.35);">{{
                        __('Contact') }}</h6>
                    <p class="mb-2">
                        <i class="fas fa-envelope me-2" style="color: #78e518; width: 16px;"></i>
                        <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-phone me-2" style="color: #78e518; width: 16px;"></i>
                        <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a>
                    </p>
                    <p class="mb-2" style="color: rgba(255,255,255,0.55); font-size: 0.9rem;">
                        <i class="fab fa-whatsapp me-2" style="color: #25d366; width: 16px;"></i>
                        {{ $settings->phone }}
                    </p>
                </div>
                <div class="col-md-4 footer-links">
                    <h6 class="text-uppercase mb-3"
                        style="font-size: 0.8rem; letter-spacing: 1.5px; color: rgba(255,255,255,0.35);">{{ __('Legal')
                        }}</h6>
                    <p class="mb-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#impressumModal">
                            <i class="fas fa-file-alt me-2" style="width: 16px;"></i>{{ __('Impressum') }}
                        </a>
                    </p>
                    <p class="mb-2">
                        <a href="#" data-bs-toggle="modal" data-bs-target="#datenschutzModal">
                            <i class="fas fa-shield-alt me-2" style="width: 16px;"></i>{{ __('Datenschutzerklärung') }}
                        </a>
                    </p>
                </div>
            </div>
            <hr class="footer-divider">
            <div class="footer-bottom text-center">
                &copy; {{ date('Y') }} {{ $settings->name }}. {{ __('All rights reserved.') }}
            </div>
        </div>
    </footer>

    <!-- Scroll to Top -->
    <button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Impressum Modal -->
    <div class="modal fade" id="impressumModal" tabindex="-1" aria-labelledby="impressumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold" id="impressumModalLabel">IMPRESSUM</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! nl2br(e($settings->impressum)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Datenschutz Modal -->
    <div class="modal fade" id="datenschutzModal" tabindex="-1" aria-labelledby="datenschutzModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-dark text-light border border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title fw-bold" id="datenschutzModalLabel">DATENSCHUTZERKLÄRUNG</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! nl2br(e($settings->datenschutz)) !!}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ===== Sticky Navbar =====
        window.addEventListener('scroll', function () {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // ===== Scroll to Top =====
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        window.addEventListener('scroll', function () {
            if (window.scrollY > 400) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });

        scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // ===== Scroll Reveal =====
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };
        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.fade-in-up').forEach(function (el) {
                observer.observe(el);
            });
        });

        // ===== Favorites =====
        function updateFavoritesCount() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const count = favorites.length;
            const el = document.getElementById('favoritesCount');
            if (el) {
                el.textContent = count;
                el.style.display = count > 0 ? 'inline-flex' : 'none';
            }
        }

        function toggleFavorite(carId) {
            let favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const index = favorites.indexOf(carId);

            if (index > -1) {
                favorites.splice(index, 1);
                $(`.toggle-favorite[data-car-id="${carId}"]`).removeClass('favorited');
            } else {
                favorites.push(carId);
                $(`.toggle-favorite[data-car-id="${carId}"]`).addClass('favorited');
            }

            localStorage.setItem('favorites', JSON.stringify(favorites));
            updateFavoritesCount();
        }

        $(document).ready(function () {
            updateFavoritesCount();

            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            favorites.forEach(id => {
                $(`.toggle-favorite[data-car-id="${id}"]`).addClass('favorited');
            });

            $(document).on('click', '.toggle-favorite', function (e) {
                e.stopPropagation();
                e.preventDefault();
                const carId = $(this).data('car-id');
                toggleFavorite(carId);
            });
        });
    </script>

    @yield('scripts')
</body>

</html>