<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Campaigns - {{ config('app.name', 'Donation Tracker') }}</title>
    <meta name="description" content="Explore our active fundraising campaigns and make a difference in communities worldwide">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #ffffff;
            --accent-color: #18BC9C;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --light-bg: #f8fafc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            background: var(--light-bg);
            padding-top: 70px; /* Prevent fixed navbar overlap */
        }
        
        .bg-primary {
            background-color: var(--primary-color) !important;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #1a252f;
            border-color: #1a252f;
        }
        
        .campaigns-hero {
            background: linear-gradient(rgba(44, 62, 80, 0.9), rgba(44, 62, 80, 0.9)), url('https://images.unsplash.com/photo-1559027615-cd4628902d4a?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0 80px;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            transition: transform 0.3s ease;
            margin-bottom: 2rem;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin: 0 auto 1rem;
        }
        
        .campaign-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border: none;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
            height: 100%;
        }
        
        .campaign-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }
        
        .campaign-image {
            height: 250px;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        
        .campaign-status {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--success-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .progress-custom {
            height: 12px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
        }
        
        .progress-bar-custom {
            background: linear-gradient(90deg, var(--success-color), var(--accent-color));
            height: 100%;
            border-radius: 10px;
            transition: width 0.6s ease;
        }
        
        .campaign-stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 1rem 0;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        
        .btn-donate {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }
        
        .btn-donate:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
            color: white;
        }
        
        .section-title {
            position: relative;
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--accent-color);
            border-radius: 2px;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: var(--primary-color) !important;
        }
        
        .days-left {
            background: var(--warning-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Custom dropdown menu styles (copied from homepage) */
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

        /* Button that looks like nav-link but with outline */
        .nav-link-btn {
            background: none;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            transition: all .15s ease-in-out;
        }
        .nav-link-btn:hover {
            background-color: var(--primary-color);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-hand-holding-heart me-2"></i>
                {{ config('app.name', 'Donation Tracker') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{ route('campaigns.index') }}">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#how-it-works">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item ms-lg-3 position-relative">
                            <button class="nav-link-btn" id="userMenuButton" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                                @if(Auth::user()->isAdmin())
                                    <span class="badge bg-warning text-dark ms-1">Admin</span>
                                @endif
                            </button>
                            <ul class="custom-dropdown-menu" id="userMenu">
                                @if(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('campaigns.my-campaigns') }}"><i class="fas fa-bullseye me-2"></i>My    Campaigns</a></li>
                                <li><a class="dropdown-item" href="{{ route('campaigns.create') }}"><i class="fas fa-plus me-2"></i>Create Campaign</a></li>
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
                            <a class="btn btn-outline-primary" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary text-white" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i>Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="campaigns-hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Our Active Campaigns</h1>
                    <p class="lead mb-5">Join us in making a meaningful impact across the globe. Every donation brings us closer to creating positive change in communities that need it most.</p>
                    
                    <!-- Stats Overview (with fallback values) -->
                    <div class="row mt-5">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="stats-icon mx-auto" style="background: var(--success-color);">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h3 class="fw-bold">{{ $stats['active_campaigns'] ?? 0 }}</h3>
                            <p class="mb-0">Active Campaigns</p>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="stats-icon mx-auto" style="background: var(--accent-color);">
                                <i class="fas fa-hand-holding-heart"></i>
                            </div>
                            <h3 class="fw-bold">${{ number_format($stats['total_raised'] ?? 0) }}</h3>
                            <p class="mb-0">Total Raised</p>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="stats-icon mx-auto" style="background: var(--warning-color);">
                                <i class="fas fa-target"></i>
                            </div>
                            <h3 class="fw-bold">${{ number_format($stats['total_goal'] ?? 0) }}</h3>
                            <p class="mb-0">Total Goals</p>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <div class="stats-icon mx-auto" style="background: var(--primary-color);">
                                <i class="fas fa-percentage"></i>
                            </div>
                            <h3 class="fw-bold">
                                @php
                                    $raised = $stats['total_raised'] ?? 0;
                                    $goal = $stats['total_goal'] ?? 0;
                                    $percentage = ($goal > 0) ? ($raised / $goal) * 100 : 0;
                                @endphp
                                {{ number_format($percentage, 1) }}%
                            </h3>
                            <p class="mb-0">Overall Progress</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Campaigns Section -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title display-5 fw-bold">Current Campaigns</h2>
                </div>
            </div>
            
            <div class="row">
                @forelse($campaigns ?? [] as $campaign)
                    <div class="col-lg-6 col-xl-4 mb-4">
                        <div class="campaign-card">
                            <!-- Campaign Image -->
                            <div class="campaign-image" style="background-image: url('{{ $campaign->getCampaignImage() ?? asset('images/default-campaign.jpg') }}');">
                                <div class="campaign-status">
                                    <i class="fas fa-circle-check me-1"></i>{{ ucfirst($campaign->status ?? 'active') }}
                                </div>
                                @if(isset($campaign->end_date) && $campaign->end_date && $campaign->end_date->isFuture())
                                    <div class="days-left" style="position: absolute; top: 1rem; left: 1rem;">
                                        <i class="fas fa-clock me-1"></i>{{ floor(abs($campaign->end_date->diffInDays())) }} days left
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Campaign Content -->
                            <div class="p-4">
                                <h4 class="fw-bold mb-3">{{ $campaign->name ?? 'Untitled Campaign' }}</h4>
                                <p class="text-muted mb-4">{{ Str::limit($campaign->description ?? '', 120) }}</p>
                                
                                <!-- Progress -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-semibold">Progress</span>
                                        <span class="badge bg-primary">{{ $campaign->progress_percentage ?? 0 }}%</span>
                                    </div>
                                    <div class="progress-custom">
                                        <div class="progress-bar-custom" style="width: {{ ($campaign->progress_percentage ?? 0) }}%"></div>
                                    </div>
                                </div>
                                
                                <!-- Campaign Stats -->
                                <div class="campaign-stats">
                                    <div class="stat-item">
                                        <div class="stat-number text-success">${{ number_format($campaign->raised_amount ?? 0) }}</div>
                                        <div class="stat-label">Raised</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">${{ number_format($campaign->goal_amount ?? 0) }}</div>
                                        <div class="stat-label">Goal</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">{{ $campaign->donations_count ?? ($campaign->donations() ? $campaign->donations()->count() : 0) }}</div>
                                        <div class="stat-label">Donors</div>
                                    </div>
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                                    <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-outline-primary flex-fill me-md-2">
                                        <i class="fas fa-info-circle me-2"></i>Learn More
                                    </a>
                                    <a href="{{ route('campaigns.show', $campaign) }}#donate" class="btn btn-donate flex-fill">
                                        <i class="fas fa-heart me-2"></i>Donate Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-bullseye text-muted mb-3" style="font-size: 4rem;"></i>
                            <h3 class="text-muted">No Active Campaigns</h3>
                            <p class="text-muted">Check back soon for new fundraising opportunities.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color));">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h2 class="display-5 fw-bold mb-4">Ready to Make a Difference?</h2>
                    <p class="lead mb-4">Your contribution, no matter the size, creates ripples of positive change that extend far beyond what you can imagine.</p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-4">
                            <i class="fas fa-user-plus me-2"></i>Join Our Community
                        </a>
                        <a href="{{ route('home') }}#contact" class="btn btn-outline-light btn-lg px-4">
                            <i class="fas fa-envelope me-2"></i>Get In Touch
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS (still needed for collapse, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom dropdown script -->
    <script>
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
    </script>
</body>
</html>