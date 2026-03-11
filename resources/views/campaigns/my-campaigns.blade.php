<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Campaigns - {{ config('app.name', 'Donation Tracker') }}</title>
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
            --danger-color: #e74c3c;
            --light-bg: #f8fafc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            background: var(--light-bg);
            padding-top: 70px; /* Prevent fixed navbar overlap */
        }
        
        .page-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }
        
        .campaign-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .campaign-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .campaign-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e9ecef;
        }
        
        .campaign-body {
            padding: 1.5rem;
        }
        
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .status-approved {
            background: #d1edff;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .progress-custom {
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            overflow: hidden;
        }
        
        .progress-bar-custom {
            background: linear-gradient(90deg, var(--success-color), var(--accent-color));
            height: 100%;
            border-radius: 5px;
            transition: width 0.6s ease;
        }
        
        .btn-create {
            background: linear-gradient(45deg, var(--success-color), var(--accent-color));
            border: none;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(39, 174, 96, 0.3);
            color: white;
        }
        
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: var(--primary-color) !important;
        }
        
        .rejection-reason {
            background: #f8f9fa;
            border-left: 4px solid var(--danger-color);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0 10px 10px 0;
        }

        /* Custom dropdown menu styles */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-toggle {
            background: none;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.25rem 0.5rem;
            color: var(--primary-color);
            cursor: pointer;
        }

        .custom-dropdown-toggle:hover {
            background-color: #e9ecef;
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

        .custom-dropdown-menu .dropdown-item.text-danger {
            color: var(--danger-color) !important;
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
                        <a class="nav-link" href="{{ route('campaigns.index') }}">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="{{ route('campaigns.my-campaigns') }}">My Campaigns</a>
                    </li>
                    @auth
                        <li class="nav-item ms-lg-3 position-relative">
                            <button class="nav-link-btn btn btn-outline-primary" id="userMenuButton" aria-expanded="false">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </button>
                            <ul class="custom-dropdown-menu" id="userMenu">
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
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">My Campaigns</h1>
                    <p class="lead mb-0">Manage your fundraising campaigns and track their progress</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('campaigns.create') }}" class="btn btn-create btn-lg">
                        <i class="fas fa-plus me-2"></i>Create Campaign
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(isset($campaigns) && $campaigns->count() > 0)
            <div class="row">
                @foreach($campaigns as $campaign)
                    <div class="col-lg-6 col-xl-4">
                        <div class="campaign-card">
                            <div class="campaign-header">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="fw-bold mb-0">{{ $campaign->name ?? 'Untitled' }}</h5>
                                    <!-- Custom dropdown per campaign -->
                                    <div class="custom-dropdown">
                                        <button class="custom-dropdown-toggle" data-campaign-dropdown="{{ $loop->index }}">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="custom-dropdown-menu" id="campaignDropdown-{{ $loop->index }}">
                                            @if(isset($campaign) && method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                                <li><a class="dropdown-item" href="{{ route('campaigns.show', $campaign) }}">
                                                    <i class="fas fa-eye me-2"></i>View Public Page
                                                </a></li>
                                            @endif
                                            <li><a class="dropdown-item" href="{{ route('campaigns.edit', $campaign) }}">
                                                <i class="fas fa-edit me-2"></i>Edit
                                            </a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" 
                                                      onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center mb-3">
                                    <span class="status-badge status-{{ $campaign->approval_status ?? 'pending' }} me-3">
                                        @if(isset($campaign) && method_exists($campaign, 'isPending') && $campaign->isPending())
                                            <i class="fas fa-clock me-1"></i>Pending Review
                                        @elseif(isset($campaign) && method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                            <i class="fas fa-check-circle me-1"></i>Approved
                                        @else
                                            <i class="fas fa-times-circle me-1"></i>Rejected
                                        @endif
                                    </span>
                                    
                                    @if(isset($campaign) && method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                        <span class="badge bg-success">{{ ucfirst($campaign->status ?? 'active') }}</span>
                                    @endif
                                </div>
                                
                                @if(isset($campaign) && method_exists($campaign, 'isRejected') && $campaign->isRejected() && $campaign->rejection_reason)
                                    <div class="rejection-reason">
                                        <h6 class="fw-bold text-danger mb-2">
                                            <i class="fas fa-exclamation-triangle me-2"></i>Rejection Reason
                                        </h6>
                                        <p class="mb-0 small">{{ $campaign->rejection_reason }}</p>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="campaign-body">
                                <p class="text-muted mb-3">{{ Str::limit($campaign->description ?? '', 100) }}</p>
                                
                                <!-- Progress -->
                                @if(isset($campaign) && method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-semibold">Progress</span>
                                            <span class="badge bg-primary">{{ $campaign->progress_percentage ?? 0 }}%</span>
                                        </div>
                                        <div class="progress-custom">
                                            <div class="progress-bar-custom" style="width: {{ $campaign->progress_percentage ?? 0 }}%"></div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Campaign Stats -->
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="fw-bold text-success">${{ number_format($campaign->raised_amount ?? 0) }}</div>
                                        <small class="text-muted">Raised</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bold">${{ number_format($campaign->goal_amount ?? 0) }}</div>
                                        <small class="text-muted">Goal</small>
                                    </div>
                                    <div class="col-4">
                                        <div class="fw-bold">{{ $campaign->donations_count ?? ($campaign->donations() ? $campaign->donations()->count() : 0) }}</div>
                                        <small class="text-muted">Donors</small>
                                    </div>
                                </div>
                                
                                <!-- Dates -->
                                <div class="row mt-3 text-center">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-start me-1"></i>
                                            {{ isset($campaign->start_date) ? $campaign->start_date->format('M j, Y') : 'N/A' }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar-end me-1"></i>
                                            {{ isset($campaign->end_date) ? $campaign->end_date->format('M j, Y') : 'N/A' }}
                                        </small>
                                    </div>
                                </div>
                                
                                @if(isset($campaign->end_date) && $campaign->end_date && $campaign->end_date->isFuture())
                                    <div class="text-center mt-2">
                                        <small class="badge bg-warning text-dark">
                                            <i class="fas fa-clock me-1"></i>{{ floor(abs($campaign->end_date->diffInDays())) }} days remaining
                                        </small>
                                    </div>
                                @endif
                                
                                <!-- Approval Info -->
                                @if(isset($campaign->approved_at) && $campaign->approved_at && isset($campaign->approver))
                                    <div class="mt-3 text-center">
                                        <small class="text-muted">
                                            @if(isset($campaign) && method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                                <i class="fas fa-check text-success me-1"></i>Approved by {{ $campaign->approver->name }}
                                            @else
                                                <i class="fas fa-times text-danger me-1"></i>Reviewed by {{ $campaign->approver->name }}
                                            @endif
                                            on {{ \Carbon\Carbon::parse($campaign->approved_at)->format('M j, Y') }}
                                        </small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-bullseye text-muted mb-4" style="font-size: 4rem;"></i>
                <h3 class="text-muted mb-3">No Campaigns Yet</h3>
                <p class="text-muted mb-4">You haven't created any campaigns yet. Start your first fundraising campaign today!</p>
                <a href="{{ route('campaigns.create') }}" class="btn btn-create btn-lg">
                    <i class="fas fa-plus me-2"></i>Create Your First Campaign
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS (still needed for collapse, alerts, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom dropdown scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // User menu dropdown
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
            }

            // Campaign dropdowns (multiple)
            const campaignToggles = document.querySelectorAll('[data-campaign-dropdown]');
            campaignToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const index = this.getAttribute('data-campaign-dropdown');
                    const menu = document.getElementById(`campaignDropdown-${index}`);
                    if (menu) {
                        // Close any other open campaign dropdowns
                        document.querySelectorAll('.custom-dropdown-menu.show').forEach(openMenu => {
                            if (openMenu !== menu) {
                                openMenu.classList.remove('show');
                            }
                        });
                        menu.classList.toggle('show');
                    }
                });
            });

            // Close dropdowns when clicking outside
            document.addEventListener('click', function(event) {
                // User menu
                if (userMenuButton && userMenu && 
                    !userMenuButton.contains(event.target) && 
                    !userMenu.contains(event.target)) {
                    userMenu.classList.remove('show');
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }

                // Campaign dropdowns
                document.querySelectorAll('.custom-dropdown-menu.show').forEach(openMenu => {
                    const parent = openMenu.closest('.custom-dropdown');
                    if (parent && !parent.contains(event.target)) {
                        openMenu.classList.remove('show');
                    }
                });
            });
        });
    </script>
</body>
</html>