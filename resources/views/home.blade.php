<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Donation Tracker') }} - Donation Management System</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS (latest stable) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #ffffff;
            --accent-color: #18BC9C;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            padding-top: 70px; /* Prevents fixed navbar from overlapping content */
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .text-primary {
            color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1a252f;
            border-color: #1a252f;
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
        }
        
        .feature-icon {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .dashboard-card {
            border-left: 5px solid var(--primary-color);
        }
        
        .stat-card {
            border-radius: 10px;
            color: white;
        }
        
        .stat-card-1 {
            background-color: #3498DB;
        }
        
        .stat-card-2 {
            background-color: #2ECC71;
        }
        
        .stat-card-3 {
            background-color: #E74C3C;
        }
        
        .stat-card-4 {
            background-color: #F39C12;
        }
        
        .donation-progress {
            height: 10px;
        }
        
        .donor-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .testimonial-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        footer {
            background-color: #1a252f;
            color: white;
        }
        
        .social-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            margin-right: 10px;
            transition: all 0.3s;
        }
        
        .social-icon:hover {
            background-color: var(--accent-color);
            color: white;
        }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }
        
        .nav-pills .nav-link {
            color: var(--primary-color);
        }

        /* Custom font weight class (since fw-semibold is not in Bootstrap 5) */
        .fw-semi-bold {
            font-weight: 600;
        }

        /* Custom dropdown menu styles */
        .custom-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            z-index: 1000;
            min-width: 200px;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            background-color: #fff;
            border: 1px solid rgba(0,0,0,.15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
            list-style: none;
            display: none;
        }

        .custom-dropdown-menu.show {
            display: block;
        }

        .custom-dropdown-menu .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
            cursor: pointer;
        }

        .custom-dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .custom-dropdown-menu .dropdown-divider {
            height: 0;
            margin: 0.5rem 0;
            overflow: hidden;
            border-top: 1px solid rgba(0,0,0,.15);
        }

        /* Ensure button looks like nav-link */
        .nav-link-btn {
            background: none;
            border: none;
            color: rgba(255,255,255,.55);
            padding: 0.5rem 1rem;
            text-decoration: none;
            transition: color .15s ease-in-out;
        }
        .nav-link-btn:hover {
            color: rgba(255,255,255,.75);
        }
        .nav-link-btn.btn-outline-light {
            border: 1px solid rgba(255,255,255,.5);
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }
        .nav-link-btn.btn-outline-light:hover {
            background-color: rgba(255,255,255,.1);
            border-color: rgba(255,255,255,.75);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-hand-holding-heart me-2"></i>
                <strong>{{ config('app.name', 'Donation Tracker') }}</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('campaigns.index') }}">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item ms-lg-3 position-relative">
                            <button class="nav-link-btn btn btn-outline-light" id="userMenuButton" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="custom-dropdown-menu" id="userMenu">
                                <li><a class="dropdown-item" href="{{ route('campaigns.my-campaigns') }}"><i class="fas fa-bullseye me-2"></i>My Campaigns</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-light" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light text-primary" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section" style="position: relative; min-height: 100vh;">
        <div class="container py-5 mt-5 h-100">
            <!-- Hero Content -->
            <div class="row align-items-center" id="hero-content">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Streamline Your Donation Management</h1>
                    <p class="lead mb-4">{{ config('app.name', 'Donation Tracker') }} helps nonprofits and charities efficiently track, manage, and optimize their donation processes with our comprehensive management system.</p>
                    <div class="d-flex gap-3">
                        <button type="button" class="btn btn-primary btn-lg px-4" onclick="playDemoVideo()">
                            <i class="fas fa-play-circle me-2"></i> Watch Demo
                        </button>
                        <a href="/register" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i> Sign Up Free
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="https://images.unsplash.com/photo-1570129477492-45c003edd2be?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Donation Management" class="img-fluid rounded shadow">
                </div>
            </div>
            
            <!-- Video Container (Hidden by default) -->
            <div id="video-container" style="display: none; position: absolute; top: 0; left: 0; right: 0; bottom: 0; z-index: 10;">
                <div class="h-100 d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2 class="text-white mb-0" id="video-title">See How It Works</h2>
                        <button type="button" class="btn btn-outline-light" onclick="closeVideo()">
                            <i class="fas fa-times me-2"></i>Close Video
                        </button>
                    </div>
                    <div class="flex-grow-1 position-relative">
                        <iframe id="hero-video-frame" 
                                src="" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen 
                                class="w-100 h-100 rounded shadow"
                                style="min-height: 400px;">
                        </iframe>
                        <!-- Error message for embedding issues -->
                        <div id="video-error" class="alert alert-warning mt-3" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Video Embedding Restricted:</strong> This video cannot be embedded due to YouTube's privacy settings. 
                            <br>Please try a different video or <a href="#" id="video-link" target="_blank" class="alert-link">watch it directly on YouTube</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">1,250+</h2>
                        <p class="mb-0 fw-semi-bold">Nonprofits Trust Us</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">${{ number_format($totalDonations ?? 0, 0) }}+</h2>
                        <p class="mb-0 fw-semi-bold">Donations Processed</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">24/7</h2>
                        <p class="mb-0 fw-semi-bold">Support Available</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="text-center p-4">
                        <h2 class="display-4 fw-bold text-primary">99.9%</h2>
                        <p class="mb-0 fw-semi-bold">Uptime Guarantee</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.featured-campaigns')
    @include('partials.how-it-works')
    @include('partials.dashboard-preview')
    @include('partials.testimonials')
    @include('partials.cta')
    @include('partials.faq')
    @include('partials.contact')
    @include('partials.footer')

    <!-- Bootstrap JS (still needed for collapse, tabs, etc., but not for dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <script>
        // Custom dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const userMenuButton = document.getElementById('userMenuButton');
            const userMenu = document.getElementById('userMenu');

            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    userMenu.classList.toggle('show');
                    const expanded = userMenu.classList.contains('show') ? 'true' : 'false';
                    userMenuButton.setAttribute('aria-expanded', expanded);
                });

                // Close menu when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenu.classList.remove('show');
                        userMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });
            }
        });

        function playDemoVideo() {
            // Get demo video settings
            fetch('/api/settings/demo-video')
                .then(response => response.json())
                .then(data => {
                    let videoUrl = data.demo_video_url || 'https://www.youtube.com/embed/ScMzIvxBSi4';
                    const videoTitle = data.demo_video_title || 'See How It Works';
                    
                    // Convert regular YouTube URL to embed format if needed
                    const originalUrl = videoUrl;
                    videoUrl = convertToEmbedUrl(videoUrl);
                    
                    // Update video title and URL
                    document.getElementById('video-title').textContent = videoTitle;
                    
                    // Reset error state
                    document.getElementById('video-error').style.display = 'none';
                    
                    // Set up the iframe with error handling
                    const iframe = document.getElementById('hero-video-frame');
                    iframe.onload = function() {
                        // Video loaded successfully
                        console.log('Video loaded successfully');
                    };
                    
                    iframe.onerror = function() {
                        // Video failed to load
                        showVideoError(originalUrl);
                    };
                    
                    // Add additional parameters for better embedding support
                    iframe.src = videoUrl + '?autoplay=1&rel=0&modestbranding=1&fs=1&cc_load_policy=0&iv_load_policy=3&autohide=0';
                    
                    // Hide hero content and show video
                    document.getElementById('hero-content').style.display = 'none';
                    document.getElementById('video-container').style.display = 'block';
                    
                    // Set up error detection after a delay
                    setTimeout(() => {
                        checkVideoEmbedding(iframe, originalUrl);
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error loading demo video settings:', error);
                    // Fallback to default working video
                    loadFallbackVideo();
                });
        }

        function checkVideoEmbedding(iframe, originalUrl) {
            try {
                // Try to access iframe content to check if it loaded properly
                const iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
                if (!iframeDoc || iframeDoc.body.innerHTML.includes('Video unavailable')) {
                    showVideoError(originalUrl);
                }
            } catch (e) {
                // Cross-origin access denied is normal, but other errors might indicate embedding issues
                if (iframe.src && iframe.src.includes('embed')) {
                    // Check if the iframe is actually showing content
                    const rect = iframe.getBoundingClientRect();
                    if (rect.height < 100) { // If iframe is collapsed, likely an error
                        showVideoError(originalUrl);
                    }
                }
            }
        }

        function showVideoError(originalUrl) {
            document.getElementById('video-error').style.display = 'block';
            document.getElementById('video-link').href = originalUrl;
        }

        function loadFallbackVideo() {
            document.getElementById('video-title').textContent = 'Demo Video';
            document.getElementById('hero-video-frame').src = 'https://www.youtube.com/embed/ScMzIvxBSi4?autoplay=1&rel=0&modestbranding=1';
            
            // Hide hero content and show video
            document.getElementById('hero-content').style.display = 'none';
            document.getElementById('video-container').style.display = 'block';
        }

        function closeVideo() {
            // Stop video
            document.getElementById('hero-video-frame').src = '';
            
            // Hide video and show hero content
            document.getElementById('video-container').style.display = 'none';
            document.getElementById('hero-content').style.display = 'block';
        }

        function convertToEmbedUrl(url) {
            // If it's already an embed URL, return as is
            if (url.includes('/embed/')) {
                return url;
            }
            
            // Convert regular YouTube URLs to embed format
            let videoId = '';
            
            if (url.includes('youtube.com/watch?v=')) {
                videoId = url.split('v=')[1];
                const ampersandPosition = videoId.indexOf('&');
                if (ampersandPosition !== -1) {
                    videoId = videoId.substring(0, ampersandPosition);
                }
            } else if (url.includes('youtu.be/')) {
                videoId = url.split('youtu.be/')[1];
                const queryPosition = videoId.indexOf('?');
                if (queryPosition !== -1) {
                    videoId = videoId.substring(0, queryPosition);
                }
            }
            
            if (videoId) {
                return `https://www.youtube.com/embed/${videoId}`;
            }
            
            return url; // Return original if can't convert
        }

        // Load dynamic hero content from settings
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/settings/hero')
                .then(response => response.json())
                .then(data => {
                    if (data.hero_title) {
                        const titleElement = document.querySelector('.hero-section h1');
                        if (titleElement) {
                            titleElement.textContent = data.hero_title;
                        }
                    }
                    
                    if (data.hero_subtitle) {
                        const subtitleElement = document.querySelector('.hero-section .lead');
                        if (subtitleElement) {
                            subtitleElement.textContent = data.hero_subtitle;
                        }
                    }
                    
                    if (data.hero_background) {
                        const heroSection = document.querySelector('.hero-section');
                        if (heroSection) {
                            heroSection.style.backgroundImage = `linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('${data.hero_background}')`;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading hero settings:', error);
                });
        });

        // Smooth scrolling for navigation links with offset for fixed header
        document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                if (this.hasAttribute('data-bs-toggle')) {
                    return;
                }
                const targetId = this.getAttribute('href');
                const target = document.querySelector(targetId);
                if (target) {
                    e.preventDefault();
                    const offsetTop = target.offsetTop - 70; // Adjust for fixed navbar height
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
    
    @include('partials.scripts')
</body>
</html>