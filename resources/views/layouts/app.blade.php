<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Car Sales')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #2a333dff;
        }
        .navbar-brand { font-weight: bold; font-size: 1.5rem; }
        .car-card { transition: transform 0.3s; margin-bottom: 30px; }
        .car-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .car-image { height: 250px; object-fit: cover; width: 100%; }
        .price-tag { color: #28a745; font-size: 1.5rem; font-weight: bold; }
        .contact-bar { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 15px 0; }
        .hero {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 150px 0;
            position: relative;
            min-height: 500px;
            width: 100%;
            text-align: center;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .hero .container {
            position: relative;
            z-index: 2;
        }

        .hero h1,
        .hero p {
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .hero {
                padding: 100px 0;
                min-height: 400px;
                background-attachment: scroll;
            }
        }
        
        .badge-custom { padding: 8px 12px; border-radius: 20px; }
        footer { background-color: #2c3e50; color: white; padding: 40px 0; margin-top: 60px; }
        
        /* Favorites styling */
        .toggle-favorite {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(0, 0, 0, 0.6);
            border: none;
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
            color: white;
            font-size: 1.2rem;
        }

        .toggle-favorite.favorited i {
            color: #dc3545;
        }

        .toggle-favorite:hover {
            transform: scale(1.1);
            background: rgba(0, 0, 0, 0.8);
        }

        .car-card {
            position: relative;
        }

        .favorites-badge {
            position: relative;
        }

        #favoritesCount {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            min-width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: none;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            padding: 0 5px;
        }
        
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
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-car"></i> {{ $settings->name }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @guest
                        <li class="nav-item favorites-badge">
                        <a class="nav-link" href="{{ route('favorites') }}">
                            <i class="fas fa-heart"></i> Favorites
                            <span id="favoritesCount">0</span>
                        </a>
                    </li>
                    @endguest
                    
                    @auth
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.settings') }}">Settings</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Admin Login</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer>
        <div class="container text-center">
            <p>&copy; 2026 {{ $settings->name }}</p>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Global favorites functionality
        function updateFavoritesCount() {
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            const count = favorites.length;
            $('#favoritesCount').text(count);
            if (count > 0) {
                $('#favoritesCount').css('display', 'flex');
            } else {
                $('#favoritesCount').hide();
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

        $(document).ready(function() {
            // Update favorites count on page load
            updateFavoritesCount();
            
            // Check which cars are favorited
            const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
            favorites.forEach(id => {
                $(`.toggle-favorite[data-car-id="${id}"]`).addClass('favorited');
            });
            
            // Toggle favorite on click
            $(document).on('click', '.toggle-favorite', function(e) {
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