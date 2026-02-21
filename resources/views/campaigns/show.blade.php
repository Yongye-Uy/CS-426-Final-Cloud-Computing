<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->name ?? 'Campaign' }} - {{ config('app.name', 'Donation Tracker') }}</title>
    <meta name="description" content="{{ Str::limit($campaign->description ?? '', 160) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2C3E50;
            --accent-color: #18BC9C;
            --success-color: #27ae60;
            --warning-color: #f39c12;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            background: #f8fafc;
            padding-top: 80px; /* Prevent fixed navbar overlap */
        }
        
        .campaign-hero {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
        }
        
        .campaign-media-container {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-top: -3rem;
            position: relative;
            z-index: 10;
        }
        
        .campaign-video {
            width: 100%;
            height: 400px;
            border: none;
        }
        
        .campaign-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .video-overlay:hover {
            background: rgba(0,0,0,0.5);
        }
        
        .play-button-large {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }
        
        .play-button-large:hover {
            background: white;
            transform: scale(1.1);
        }
        
        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }
        
        .btn-donate {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            border: none;
            color: white;
            padding: 1rem 3rem;
            border-radius: 50px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }
        
        .btn-donate:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(39, 174, 96, 0.4);
            color: white;
        }
        
        .progress-custom {
            height: 20px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            margin: 1rem 0;
        }
        
        .progress-bar-custom {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            height: 100%;
            border-radius: 10px;
            transition: width 0.8s ease;
        }
        
        .donor-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            border-left: 4px solid var(--accent-color);
        }
        
        .donor-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .status-badge {
            background: var(--success-color);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .days-left {
            background: var(--warning-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.875rem;
            font-weight: 600;
        }
        
        .modal-content {
            border-radius: 20px;
            border: none;
        }
        
        .modal-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
        }
        
        .donation-amount-btn {
            border: 2px solid var(--accent-color);
            color: var(--accent-color);
            background: transparent;
            border-radius: 10px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0.25rem;
        }
        
        .donation-amount-btn:hover,
        .donation-amount-btn.active {
            background: var(--accent-color);
            color: white;
        }
        
        /* Credit Card Modal Styles */
        #creditCardModal .modal-dialog {
            max-width: 500px;
        }

        .cc-input-group {
            position: relative;
        }

        .cc-input-group i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .btn-success {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            border: none;
            border-radius: 25px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
        }
        
        .alert-info {
            background-color: rgba(24, 188, 156, 0.1);
            border: 1px solid var(--accent-color);
            color: var(--primary-color);
            border-radius: 12px;
        }
        
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Custom dropdown menu styles */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-toggle {
            background: none;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .custom-dropdown-toggle:hover {
            background-color: var(--primary-color);
            color: white;
        }

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
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="color: var(--primary-color);">
                <i class="fas fa-hand-holding-heart me-2"></i>
                {{ config('app.name', 'Donation Tracker') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" style="color: var(--primary-color);">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="{{ route('campaigns.index') }}" style="color: var(--primary-color);">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#how-it-works" style="color: var(--primary-color);">How It Works</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#contact" style="color: var(--primary-color);">Contact</a>
                    </li>
                    @auth
                        <li class="nav-item ms-lg-3 position-relative">
                            <button class="custom-dropdown-toggle" id="userMenuButton" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name ?? 'User' }}
                                @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                                    <span class="badge bg-warning text-dark ms-1">Admin</span>
                                @endif
                            </button>
                            <ul class="custom-dropdown-menu" id="userMenu">
                                @if(method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('campaigns.my-campaigns') }}"><i class="fas fa-bullseye me-2"></i>My Campaigns</a></li>
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

    <!-- Campaign Hero -->
    <section class="campaign-hero">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('campaigns.index') }}" class="text-white">Campaigns</a></li>
                    <li class="breadcrumb-item active text-white-50" aria-current="page">{{ Str::limit($campaign->name ?? 'Campaign', 30) }}</li>
                </ol>
            </nav>

            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <div class="status-badge me-3">
                            <i class="fas fa-circle-check me-2"></i>{{ ucfirst($campaign->status ?? 'active') }}
                        </div>
                        @if(isset($campaign->end_date) && $campaign->end_date && $campaign->end_date->isFuture())
                            <div class="days-left">
                                <i class="fas fa-clock me-2"></i>{{ floor(abs($campaign->end_date->diffInDays())) }} days remaining
                            </div>
                        @endif
                    </div>
                    <h1 class="display-4 fw-bold mb-4">{{ $campaign->name ?? 'Untitled Campaign' }}</h1>
                    <p class="lead mb-0">{{ Str::limit($campaign->description ?? '', 200) }}</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <button class="btn btn-donate btn-lg" data-bs-toggle="modal" data-bs-target="#donationModal">
                        <i class="fas fa-heart me-2"></i>Donate Now
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Campaign Media & Content -->
    <section class="py-5">
        <div class="container">
            <div class="campaign-media-container mb-5">
                @if(!empty($campaign->video_url))
                    <div class="position-relative">
                        <div id="videoContainer">
                            <img src="{{ $campaign->getVideoThumbnail() ?? asset('images/default-video-thumb.jpg') }}" class="campaign-image" alt="{{ $campaign->name }}">
                            <div class="video-overlay" onclick="loadVideo()">
                                <div class="play-button-large">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <img src="{{ $campaign->getCampaignImage() ?? asset('images/default-campaign.jpg') }}" class="campaign-image" alt="{{ $campaign->name }}">
                @endif
            </div>

            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Progress Section -->
                    <div class="stats-card">
                        <div class="row text-center mb-4">
                            <div class="col-md-4">
                                <div style="font-size: 2.5rem; font-weight: 700; color: var(--success-color);">${{ number_format($campaign->raised_amount ?? 0) }}</div>
                                <div style="color: #6c757d;">Raised</div>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color);">${{ number_format($campaign->goal_amount ?? 0) }}</div>
                                <div style="color: #6c757d;">Goal</div>
                            </div>
                            <div class="col-md-4">
                                <div style="font-size: 2.5rem; font-weight: 700; color: var(--primary-color);">{{ $campaign->donations ? $campaign->donations()->count() : 0 }}</div>
                                <div style="color: #6c757d;">Supporters</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold fs-5">Campaign Progress</span>
                            <span class="badge bg-primary fs-6">{{ $campaign->progress_percentage ?? 0 }}%</span>
                        </div>
                        <div class="progress-custom">
                            <div class="progress-bar-custom" style="width: {{ $campaign->progress_percentage ?? 0 }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small">
                            <span>${{ number_format($campaign->raised_amount ?? 0) }} raised</span>
                            <span>${{ number_format(($campaign->goal_amount ?? 0) - ($campaign->raised_amount ?? 0)) }} to go</span>
                        </div>
                    </div>

                    <!-- Campaign Description -->
                    <div class="stats-card">
                        <h3 class="fw-bold mb-4"><i class="fas fa-info-circle me-2 text-primary"></i>About This Campaign</h3>
                        <p class="lead mb-4">{{ $campaign->description ?? 'No description provided.' }}</p>
                        
                        @if(isset($campaign->start_date) && $campaign->start_date)
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="color: var(--primary-color);"><i class="fas fa-calendar-start me-2"></i>Campaign Started</h5>
                                    <p class="mb-3">{{ $campaign->start_date->format('F j, Y') }}</p>
                                </div>
                                @if(isset($campaign->end_date) && $campaign->end_date)
                                    <div class="col-md-6">
                                        <h5 style="color: var(--primary-color);"><i class="fas fa-calendar-end me-2"></i>Campaign Ends</h5>
                                        <p class="mb-3">{{ $campaign->end_date->format('F j, Y') }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Recent Donations -->
                    <div class="stats-card">
                        <h3 class="fw-bold mb-4"><i class="fas fa-users me-2 text-primary"></i>Recent Supporters</h3>
                        @if(isset($recentDonations) && $recentDonations->count() > 0)
                            @foreach($recentDonations as $donation)
                                <div class="donor-card">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="donor-avatar me-3">
                                                {{ strtoupper(substr($donation->donor->first_name ?? 'U', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $donation->donor->full_name ?? 'Anonymous' }}</div>
                                                <div class="text-muted small">
                                                    <i class="fas fa-clock me-1"></i>{{ isset($donation->created_at) ? $donation->created_at->diffForHumans() : 'N/A' }}
                                                    @if(!empty($donation->purpose))
                                                        • {{ $donation->purpose }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success fs-4">${{ number_format($donation->amount ?? 0, 2) }}</div>
                                            <div class="text-muted small">
                                                <i class="fas fa-credit-card me-1"></i>{{ ucfirst(str_replace('_', ' ', $donation->payment_method ?? 'unknown')) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-heart text-muted mb-3" style="font-size: 4rem;"></i>
                                <h4 class="text-muted">Be the First Supporter!</h4>
                                <p class="text-muted">Your donation will be the first step towards making this campaign a success.</p>
                                <button class="btn btn-donate" data-bs-toggle="modal" data-bs-target="#donationModal">
                                    <i class="fas fa-heart me-2"></i>Make the First Donation
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Quick Actions -->
                    <div class="stats-card text-center">
                        <h4 class="fw-bold mb-4">Support This Campaign</h4>
                        <div class="d-grid gap-3">
                            <button class="btn btn-donate btn-lg" data-bs-toggle="modal" data-bs-target="#donationModal">
                                <i class="fas fa-heart me-2"></i>Donate Now
                            </button>
                            <button class="btn btn-outline-primary" onclick="shareOnFacebook()">
                                <i class="fas fa-share me-2"></i>Share Campaign
                            </button>
                        </div>
                    </div>

                    <!-- Campaign Stats -->
                    <div class="stats-card">
                        <h4 class="fw-bold mb-4">Campaign Statistics</h4>
                        <div class="row text-center g-3">
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary-color);">{{ $campaign->donations ? $campaign->donations()->count() : 0 }}</div>
                                    <div style="color: #6c757d; font-size: 1rem;">Total Supporters</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary-color);">${{ number_format($campaign->donations ? ($campaign->donations()->avg('amount') ?? 0) : 0) }}</div>
                                    <div style="color: #6c757d; font-size: 1rem;">Average Donation</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary-color);">${{ number_format(($campaign->goal_amount ?? 0) - ($campaign->raised_amount ?? 0)) }}</div>
                                    <div style="color: #6c757d; font-size: 1rem;">Still Needed</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border rounded p-3">
                                    <div style="font-size: 1.8rem; font-weight: 700; color: var(--primary-color);">
                                        @if(isset($campaign->end_date) && $campaign->end_date && $campaign->end_date->isFuture())
                                            {{ floor(abs($campaign->end_date->diffInDays())) }}
                                        @else
                                            0
                                        @endif
                                    </div>
                                    <div style="color: #6c757d; font-size: 1rem;">Days Left</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation Modal -->
    <div class="modal fade" id="donationModal" tabindex="-1" aria-labelledby="donationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="donationModalLabel">
                        <i class="fas fa-heart me-2"></i>Support: {{ $campaign->name ?? 'Campaign' }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Choose Your Donation Amount</h4>
                        <p class="text-muted">Every contribution makes a difference</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <button class="donation-amount-btn" data-amount="25">$25</button>
                            <button class="donation-amount-btn" data-amount="50">$50</button>
                            <button class="donation-amount-btn" data-amount="100">$100</button>
                            <button class="donation-amount-btn" data-amount="250">$250</button>
                            <button class="donation-amount-btn" data-amount="500">$500</button>
                            <button class="donation-amount-btn" data-amount="custom">Custom</button>
                        </div>
                    </div>
                    
                    <form id="donationForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="number" class="form-control" id="donationAmount" placeholder="Amount" min="1" required>
                                    <label for="donationAmount">Donation Amount ($)</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="donationFrequency">
                                        <option value="one-time">One-time</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="quarterly">Quarterly</option>
                                        <option value="annually">Annually</option>
                                    </select>
                                    <label for="donationFrequency">Frequency</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="donorName" placeholder="Full Name" required 
                                   @auth value="{{ Auth::user()->name ?? '' }}" @endauth>
                            <label for="donorName">Full Name</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="donorEmail" placeholder="Email" required
                                   @auth value="{{ Auth::user()->email ?? '' }}" @endauth>
                            <label for="donorEmail">Email Address</label>
                        </div>
                        
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="donationMessage" placeholder="Optional message" style="height: 100px"></textarea>
                            <label for="donationMessage">Message (Optional)</label>
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="anonymousDonation">
                            <label class="form-check-label" for="anonymousDonation">
                                Make this donation anonymous
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-donate" onclick="showCreditCardPayment()">
                        <i class="fas fa-credit-card me-2"></i>Complete Donation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Credit Card Payment Modal -->
    <div class="modal fade" id="creditCardModal" tabindex="-1" aria-labelledby="creditCardModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="creditCardModalLabel">
                        <i class="fas fa-credit-card me-2"></i>Credit Card Payment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Payment Amount Display -->
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Payment Amount</h4>
                        <div class="fs-2 fw-bold text-success" id="ccPaymentAmount">$0</div>
                    </div>

                    <form id="creditCardForm">
                        <div class="mb-3">
                            <label for="ccNumber" class="form-label fw-semibold">Card Number</label>
                            <div class="cc-input-group">
                                <input type="text" class="form-control form-control-lg" id="ccNumber"
                                       placeholder="4242 4242 4242 4242" maxlength="19" required
                                       autocomplete="off">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="form-text">Test: 4242 4242 4242 4242 (success) or 4000 0000 0000 0002 (decline)</div>
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <div class="mb-3">
                                    <label for="ccExpiry" class="form-label fw-semibold">Expiry Date</label>
                                    <input type="text" class="form-control form-control-lg" id="ccExpiry"
                                           placeholder="MM/YY" maxlength="5" required autocomplete="off">
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="mb-3">
                                    <label for="ccCvv" class="form-label fw-semibold">CVV</label>
                                    <input type="password" class="form-control form-control-lg" id="ccCvv"
                                           placeholder="123" maxlength="3" required autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Processing State -->
                    <div id="ccProcessing" class="text-center d-none py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Processing...</span>
                        </div>
                        <p class="mt-2 mb-0">Processing payment...</p>
                    </div>

                    <!-- Success Message -->
                    <div id="ccSuccess" class="alert alert-success d-none">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Payment Successful!</strong>
                        <p class="mb-0 mt-1" id="ccSuccessMessage"></p>
                    </div>

                    <!-- Error Message -->
                    <div id="ccError" class="alert alert-danger d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="ccErrorMessage"></span>
                    </div>
                </div>
                <div class="modal-footer" id="ccFooter">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-donate" id="ccPayBtn" onclick="processCreditCardPayment()">
                        <i class="fas fa-lock me-2"></i>Pay Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
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

    <script>
        let donationId = null;

        // Auto-open donation modal if URL contains #donate
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#donate') {
                const donationModal = new bootstrap.Modal(document.getElementById('donationModal'));
                donationModal.show();
            }
        });

        // Video functionality
        @if(!empty($campaign->video_url))
        function loadVideo() {
            const videoContainer = document.getElementById('videoContainer');
            const embedUrl = '{{ $campaign->getVideoEmbedUrl() }}';
            videoContainer.innerHTML = `<iframe src="${embedUrl}" class="campaign-video" allowfullscreen></iframe>`;
        }
        @endif

        // Donation amount selection
        document.querySelectorAll('.donation-amount-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.donation-amount-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const amount = this.dataset.amount;
                if (amount !== 'custom') {
                    document.getElementById('donationAmount').value = amount;
                } else {
                    document.getElementById('donationAmount').value = '';
                    document.getElementById('donationAmount').focus();
                }
            });
        });

        // Card number formatting (add spaces every 4 digits)
        document.getElementById('ccNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(.{4})/g, '$1 ').trim();
            e.target.value = value;
        });

        // Expiry date formatting (MM/YY)
        document.getElementById('ccExpiry').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            e.target.value = value;
        });

        // CVV: digits only
        document.getElementById('ccCvv').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '');
        });

        // Show Credit Card Payment
        function showCreditCardPayment() {
            const amount = document.getElementById('donationAmount').value;
            const name = document.getElementById('donorName').value;
            const email = document.getElementById('donorEmail').value;
            const message = document.getElementById('donationMessage').value;
            const anonymous = document.getElementById('anonymousDonation').checked;

            if (!amount || !name || !email) {
                alert('Please fill in all required fields (Amount, Name, Email).');
                return;
            }

            // Create the donation record as pending
            const formData = new FormData();
            formData.append('campaign_id', {{ $campaign->id ?? 0 }});
            formData.append('amount', amount);
            formData.append('donor_name', name);
            formData.append('donor_email', email);
            formData.append('message', message);
            formData.append('anonymous', anonymous ? '1' : '0');
            formData.append('payment_method', 'credit_card');
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("donations.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    donationId = data.donation_id;

                    // Reset credit card form state
                    document.getElementById('creditCardForm').reset();
                    document.getElementById('ccProcessing').classList.add('d-none');
                    document.getElementById('ccSuccess').classList.add('d-none');
                    document.getElementById('ccError').classList.add('d-none');
                    document.getElementById('creditCardForm').classList.remove('d-none');
                    document.getElementById('ccFooter').classList.remove('d-none');
                    document.getElementById('ccPayBtn').disabled = false;

                    // Set payment amount
                    document.getElementById('ccPaymentAmount').textContent = '$' + parseFloat(amount).toFixed(2);

                    // Show credit card modal
                    const ccModal = new bootstrap.Modal(document.getElementById('creditCardModal'));
                    ccModal.show();
                } else {
                    let errorMessage = 'Error: ' + data.message;
                    if (data.errors) {
                        errorMessage += '\n\nValidation Errors:\n';
                        Object.keys(data.errors).forEach(field => {
                            errorMessage += `- ${field}: ${data.errors[field].join(', ')}\n`;
                        });
                    }
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Error creating donation:', error);
                alert('There was an error creating your donation. Please try again.');
            });
        }

        // Process Credit Card Payment
        function processCreditCardPayment() {
            const cardNumber = document.getElementById('ccNumber').value;
            const expiry = document.getElementById('ccExpiry').value;
            const cvv = document.getElementById('ccCvv').value;

            // Basic client-side validation
            const cleanCardNumber = cardNumber.replace(/\s/g, '');
            if (cleanCardNumber.length < 13 || cleanCardNumber.length > 19) {
                showCCError('Please enter a valid card number.');
                return;
            }
            if (!/^\d{2}\/\d{2}$/.test(expiry)) {
                showCCError('Please enter a valid expiry date (MM/YY).');
                return;
            }
            if (cvv.length !== 3) {
                showCCError('Please enter a valid 3-digit CVV.');
                return;
            }

            // Show processing state
            document.getElementById('creditCardForm').classList.add('d-none');
            document.getElementById('ccError').classList.add('d-none');
            document.getElementById('ccPayBtn').disabled = true;
            document.getElementById('ccFooter').classList.add('d-none');
            document.getElementById('ccProcessing').classList.remove('d-none');

            fetch('{{ route("donations.process-credit-card") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    donation_id: donationId,
                    card_number: cardNumber,
                    expiry: expiry,
                    cvv: cvv
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('ccProcessing').classList.add('d-none');

                if (data.success) {
                    // Show success
                    document.getElementById('ccSuccessMessage').textContent = data.message;
                    document.getElementById('ccSuccess').classList.remove('d-none');

                    // Auto-reload after 3 seconds
                    setTimeout(() => {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('creditCardModal'));
                        modal.hide();
                        location.reload();
                    }, 3000);
                } else {
                    // Show error and let user try again
                    showCCError(data.message || 'Payment failed. Please try again.');
                    document.getElementById('creditCardForm').classList.remove('d-none');
                    document.getElementById('ccFooter').classList.remove('d-none');
                    document.getElementById('ccPayBtn').disabled = false;
                }
            })
            .catch(error => {
                console.error('Payment error:', error);
                document.getElementById('ccProcessing').classList.add('d-none');
                showCCError('Network error. Please try again.');
                document.getElementById('creditCardForm').classList.remove('d-none');
                document.getElementById('ccFooter').classList.remove('d-none');
                document.getElementById('ccPayBtn').disabled = false;
            });
        }

        function showCCError(message) {
            document.getElementById('ccErrorMessage').textContent = message;
            document.getElementById('ccError').classList.remove('d-none');
        }

        // Share functionality
        function shareOnFacebook() {
            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent('Check out this amazing campaign: {{ $campaign->name ?? "Campaign" }}');
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${text}`, '_blank', 'width=600,height=400');
        }
    </script>
</body>
</html> 