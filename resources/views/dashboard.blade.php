<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Donation Tracking System</title>
    <meta name="description" content="Your donation tracking dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --light-bg: #f8fafc;
            --dark-text: #2c3e50;
            --gray-text: #6c757d;
        }

        body {
            background: var(--light-bg);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 80px; /* Prevent fixed navbar overlap */
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark-text);
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background: var(--secondary-color);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
        }

        .btn-primary:hover {
            background: var(--primary-color);
        }

        /* Custom dropdown menu styles */
        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown-toggle {
            background: none;
            border: none;
            color: var(--primary-color);
            font-weight: 500;
            padding: 0.5rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .custom-dropdown-toggle:hover {
            color: var(--secondary-color);
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
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-heart me-2"></i>DonationTracker
            </a>
            <div class="navbar-nav ms-auto">
                @auth
                <div class="custom-dropdown">
                    <button class="custom-dropdown-toggle" id="userMenuButton" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name ?? 'User' }}
                    </button>
                    <ul class="custom-dropdown-menu" id="userMenu">
                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
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
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Dashboard Header -->
    <div class="dashboard-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Welcome back, {{ Auth::user()->name ?? 'User' }}!</h1>
                    <p class="lead mb-0">Here's what's happening with your donation tracking today.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="text-white-50">
                        <i class="fas fa-calendar me-2"></i>{{ date('l, F j, Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Content -->
    <div class="container">
        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Stats Cards (with fallback values) -->
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background: var(--success-color);">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-number">{{ number_format(App\Models\Donor::count() ?? 0) }}</div>
                    <div class="text-muted">Total Donors</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background: var(--secondary-color);">
                        <i class="fas fa-hand-holding-heart"></i>
                    </div>
                    <div class="stats-number">${{ number_format(App\Models\Donation::where('status', 'completed')->sum('amount') ?? 0) }}</div>
                    <div class="text-muted">Total Donations</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background: var(--warning-color);">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <div class="stats-number">{{ App\Models\Campaign::count() ?? 0 }}</div>
                    <div class="text-muted">Active Campaigns</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stats-card">
                    <div class="stats-icon" style="background: var(--danger-color);">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="stats-number">{{ App\Models\Donation::whereDate('created_at', today())->count() ?? 0 }}</div>
                    <div class="text-muted">Today's Donations</div>
                </div>
            </div>
        </div>

        <!-- Management Tabs -->
        <div class="row">
            <div class="col-12">
                <div class="stats-card">
                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-donations-tab" data-bs-toggle="pill" data-bs-target="#pills-donations" type="button" role="tab">
                                <i class="fas fa-heart me-2"></i>Recent Donations
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-users-tab" data-bs-toggle="pill" data-bs-target="#pills-users" type="button" role="tab">
                                <i class="fas fa-users me-2"></i>All Users
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-campaigns-tab" data-bs-toggle="pill" data-bs-target="#pills-campaigns" type="button" role="tab">
                                <i class="fas fa-bullseye me-2"></i>Campaigns
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-donors-tab" data-bs-toggle="pill" data-bs-target="#pills-donors" type="button" role="tab">
                                <i class="fas fa-handshake me-2"></i>Top Donors
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-testimonials-tab" data-bs-toggle="pill" data-bs-target="#pills-testimonials" type="button" role="tab">
                                <i class="fas fa-quote-left me-2"></i>Testimonials
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-settings-tab" data-bs-toggle="pill" data-bs-target="#pills-settings" type="button" role="tab">
                                <i class="fas fa-cog me-2"></i>Settings
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="pills-tabContent">
                        <!-- Recent Donations Tab -->
                        <div class="tab-pane fade show active" id="pills-donations" role="tabpanel">
                            <h4 class="mb-4">Recent Donations</h4>
                            
                            <!-- Pending Donations Alert (with fallback) -->
                            @if(isset($stats) && ($stats['pending_donations_count'] ?? 0) > 0)
                                <div class="alert alert-warning mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>{{ $stats['pending_donations_count'] ?? 0 }} pending donations</strong> 
                                            totaling ${{ number_format($stats['pending_donations'] ?? 0, 2) }}
                                            <br><small>These donations are waiting for payment completion</small>
                                        </div>
                                        <form method="POST" action="{{ route('admin.donations.cleanup') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning btn-sm" 
                                                    onclick="return confirm('This will delete pending donations older than 2 hours. Continue?')">
                                                <i class="fas fa-broom me-1"></i>Cleanup Old
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            
                            @if(isset($recentDonations) && $recentDonations->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Donor</th>
                                                <th>Amount</th>
                                                <th>Campaign</th>
                                                <th>Date</th>
                                                <th>Method</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentDonations as $donation)
                                            <tr class="{{ $donation->status === 'pending' ? 'table-warning' : '' }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            <i class="fas fa-user-circle text-muted"></i>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $donation->donor->full_name ?? 'Unknown' }}</div>
                                                            <div class="text-muted small">{{ $donation->donor->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-bold {{ $donation->status === 'completed' ? 'text-success' : 'text-warning' }}">
                                                    ${{ number_format($donation->amount ?? 0, 2) }}
                                                </td>
                                                <td>{{ $donation->campaign->name ?? 'General' }}</td>
                                                <td>{{ isset($donation->created_at) ? $donation->created_at->format('M j, Y') : 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-light text-dark">{{ ucfirst($donation->payment_method ?? 'unknown') }}</span>
                                                </td>
                                                <td>
                                                    @if($donation->status === 'completed')
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Completed
                                                        </span>
                                                    @elseif($donation->status === 'pending')
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>{{ ucfirst($donation->status ?? 'unknown') }}
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-heart text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No donations yet</h5>
                                    <p class="text-muted">Start by adding your first donation to the system.</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- All Users Tab -->
                        <div class="tab-pane fade" id="pills-users" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">All Users</h4>
                                <button class="btn btn-primary btn-sm" onclick="addUser()">
                                    <i class="fas fa-user-plus me-2"></i>Add User
                                </button>
                            </div>
                            @php $users = App\Models\User::withCount('campaigns')->latest()->get(); @endphp
                            @if($users->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                                <th>Campaigns</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($users as $user)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $user->name }}</div>
                                                            <div class="text-muted small">ID: {{ $user->id }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @if(method_exists($user, 'isAdmin') && $user->isAdmin())
                                                        <span class="badge bg-danger">Admin</span>
                                                    @else
                                                        <span class="badge bg-secondary">User</span>
                                                    @endif
                                                </td>
                                                <td>{{ isset($user->created_at) ? $user->created_at->format('M j, Y') : 'N/A' }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $user->campaigns_count ?? 0 }}</span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="viewUser({{ $user->id }})" title="View User">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="editUser({{ $user->id }})" title="Edit User">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        @if($user->id !== (Auth::id() ?? 0) && !(method_exists($user, 'isAdmin') && $user->isAdmin()))
                                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteUser({{ $user->id }}, '{{ $user->name }}')" title="Delete User">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No users found</h5>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Campaigns Tab -->
                        <div class="tab-pane fade" id="pills-campaigns" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Campaign Management</h4>
                                <div>
                                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-primary btn-sm me-2">
                                        <i class="fas fa-cog me-2"></i>Full Admin Panel
                                    </a>
                                    <a href="{{ route('campaigns.create') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Create Campaign
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Campaign Status Summary -->
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <div class="card bg-warning text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-clock fa-2x mb-2"></i>
                                            <h4>{{ App\Models\Campaign::pending()->count() ?? 0 }}</h4>
                                            <p class="mb-0">Pending</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-success text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-check-circle fa-2x mb-2"></i>
                                            <h4>{{ App\Models\Campaign::approved()->count() ?? 0 }}</h4>
                                            <p class="mb-0">Approved</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-danger text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-times-circle fa-2x mb-2"></i>
                                            <h4>{{ App\Models\Campaign::rejected()->count() ?? 0 }}</h4>
                                            <p class="mb-0">Rejected</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="card bg-primary text-white h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-bullseye fa-2x mb-2"></i>
                                            <h4>{{ App\Models\Campaign::count() ?? 0 }}</h4>
                                            <p class="mb-0">Total</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @php $campaigns = App\Models\Campaign::with(['user', 'creator'])->latest()->take(15)->get(); @endphp
                            @if($campaigns->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Campaign</th>
                                                <th>Creator</th>
                                                <th>Goal</th>
                                                <th>Raised</th>
                                                <th>Approval Status</th>
                                                <th>Campaign Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($campaigns as $campaign)
                                            <tr>
                                                <td>
                                                    <div>
                                                        <div class="fw-semibold">{{ Str::limit($campaign->name ?? '', 25) }}</div>
                                                        <div class="text-muted small">Created {{ isset($campaign->created_at) ? $campaign->created_at->diffForHumans() : 'N/A' }}</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-muted small">{{ $campaign->creator ? $campaign->creator->name : 'Unknown User' }}</div>
                                                </td>
                                                <td class="fw-bold">${{ number_format($campaign->goal_amount ?? 0) }}</td>
                                                <td class="fw-bold text-success">${{ number_format($campaign->raised_amount ?? 0) }}</td>
                                                <td>
                                                    @if(method_exists($campaign, 'isPending') && $campaign->isPending())
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock me-1"></i>Pending
                                                        </span>
                                                    @elseif(method_exists($campaign, 'isApproved') && $campaign->isApproved())
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Approved
                                                        </span>
                                                    @else
                                                        <span class="badge bg-danger">
                                                            <i class="fas fa-times me-1"></i>Rejected
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ ($campaign->status ?? '') === 'active' ? 'success' : (($campaign->status ?? '') === 'paused' ? 'warning' : 'secondary') }}">
                                                        {{ ucfirst($campaign->status ?? 'unknown') }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="viewCampaign({{ $campaign->id }})" title="View Details">
                                                            <i class="fas fa-eye"></i>
                                                        </button>
                                                        
                                                        @if(method_exists($campaign, 'isPending') && $campaign->isPending())
                                                            <button type="button" class="btn btn-outline-success btn-sm" onclick="approveCampaign({{ $campaign->id }}, '{{ $campaign->name }}')" title="Approve">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="rejectCampaign({{ $campaign->id }}, '{{ $campaign->name }}')" title="Reject">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        @endif
                                                        
                                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteCampaign({{ $campaign->id }}, '{{ $campaign->name }}')" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                @if(App\Models\Campaign::count() > 15)
                                    <div class="text-center mt-3">
                                        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-primary">
                                            <i class="fas fa-list me-2"></i>View All Campaigns ({{ App\Models\Campaign::count() }} total)
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-bullseye text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No campaigns found</h5>
                                    <p class="text-muted">Start by creating your first campaign.</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Top Donors Tab -->
                        <div class="tab-pane fade" id="pills-donors" role="tabpanel">
                            <h4 class="mb-4">Top Donors</h4>
                            @php $topDonors = App\Models\Donor::withSum('donations', 'amount')->withCount('donations')->orderByDesc('donations_sum_amount')->take(10)->get(); @endphp
                            @if($topDonors->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Donor</th>
                                                <th>Total Donated</th>
                                                <th>Donations Count</th>
                                                <th>First Donation</th>
                                                <th>Last Donation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($topDonors as $donor)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar me-3">
                                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                {{ strtoupper(substr($donor->first_name ?? 'U', 0, 1)) }}
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="fw-semibold">{{ $donor->full_name ?? 'Unknown' }}</div>
                                                            <div class="text-muted small">{{ $donor->email ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-success">${{ number_format($donor->donations_sum_amount ?? 0, 2) }}</td>
                                                <td>
                                                    <span class="badge bg-primary">{{ $donor->donations_count ?? 0 }}</span>
                                                </td>
                                                <td>{{ $donor->donations()->oldest()->first()?->created_at?->format('M j, Y') ?? 'N/A' }}</td>
                                                <td>{{ $donor->donations()->latest()->first()?->created_at?->format('M j, Y') ?? 'N/A' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-5">
                                    <i class="fas fa-handshake text-muted mb-3" style="font-size: 3rem;"></i>
                                    <h5 class="text-muted">No donors found</h5>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Testimonials Tab -->
                        <div class="tab-pane fade" id="pills-testimonials" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Testimonials Management</h4>
                                <button class="btn btn-primary btn-sm" onclick="addTestimonial()">
                                    <i class="fas fa-plus me-2"></i>Add Testimonial
                                </button>
                            </div>
                            <div id="testimonials-container">
                                <div class="text-center py-5">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading testimonials...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Settings Tab -->
                        <div class="tab-pane fade" id="pills-settings" role="tabpanel">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h4 class="mb-0">Site Settings</h4>
                                <button class="btn btn-success btn-sm" onclick="initializeDefaultSettings()">
                                    <i class="fas fa-sync me-2"></i>Initialize Defaults
                                </button>
                            </div>
                            <div id="settings-container">
                                <div class="text-center py-5">
                                    <div class="spinner-border" role="status">
                                        <span class="visually-hidden">Loading settings...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals (unchanged, keep as is) -->
    <!-- User View Modal -->
    <div class="modal fade" id="userViewModal" tabindex="-1" aria-labelledby="userViewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userViewModalLabel">
                        <i class="fas fa-user-circle me-2"></i>User Details
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userViewContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Edit Modal -->
    <div class="modal fade" id="userEditModal" tabindex="-1" aria-labelledby="userEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userEditModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="userEditContent">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonial Modal -->
    <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="testimonialModalLabel">
                        <i class="fas fa-quote-left me-2"></i>Add Testimonial
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="testimonialForm">
                        <input type="hidden" id="testimonial_id" name="testimonial_id">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="donor_name" class="form-label">
                                        <i class="fas fa-user me-1"></i>Donor Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" id="donor_name" name="donor_name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="donor_title" class="form-label">
                                        <i class="fas fa-briefcase me-1"></i>Title/Position
                                    </label>
                                    <input type="text" class="form-control" id="donor_title" name="donor_title">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="content" class="form-label">
                                <i class="fas fa-comment me-1"></i>Testimonial Content <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="content" name="content" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="rating" class="form-label">
                                        <i class="fas fa-star me-1"></i>Rating
                                    </label>
                                    <select class="form-select" id="rating" name="rating" required>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured">
                                        <label class="form-check-label" for="is_featured">
                                            Featured
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                        <label class="form-check-label" for="is_active">
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveTestimonial()">
                        <i class="fas fa-save me-1"></i>Save Testimonial
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Rejection Modal -->
    <div class="modal fade" id="campaignRejectModal" tabindex="-1" aria-labelledby="campaignRejectModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="campaignRejectModalLabel">
                        <i class="fas fa-times-circle me-2 text-danger"></i>Reject Campaign
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        You are about to reject the campaign: <strong id="rejectCampaignName"></strong>
                    </div>
                    <form id="campaignRejectForm">
                        <input type="hidden" id="reject_campaign_id" name="campaign_id">
                        <div class="mb-3">
                            <label for="rejection_reason" class="form-label">
                                <i class="fas fa-comment me-1"></i>Rejection Reason <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="4" 
                                      placeholder="Please provide a detailed reason for rejecting this campaign..." required></textarea>
                            <div class="form-text">Minimum 10 characters required.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="submitCampaignRejection()">
                        <i class="fas fa-times me-1"></i>Reject Campaign
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
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
    
    <!-- Other JavaScript functions (unchanged) -->
    <script>
        // User Management Functions
        function viewUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('userViewModal'));
            modal.show();
            
            // Load user details
            fetch(`/admin/users/${userId}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('userViewContent').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading user details:', error);
                    document.getElementById('userViewContent').innerHTML = 
                        '<div class="alert alert-danger">Failed to load user details.</div>';
                });
        }
        
        function editUser(userId) {
            const modal = new bootstrap.Modal(document.getElementById('userEditModal'));
            modal.show();
            
            // Load user edit form
            fetch(`/admin/users/${userId}/edit`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('userEditContent').innerHTML = html;
                })
                .catch(error => {
                    console.error('Error loading user edit form:', error);
                    document.getElementById('userEditContent').innerHTML = 
                        '<div class="alert alert-danger">Failed to load user edit form.</div>';
                });
        }
        
        function deleteUser(userId, userName) {
            if (confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
                // Create form and submit
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userId}`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    form.appendChild(csrfInput);
                }
                
                // Add method field for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Testimonials Management
        function loadTestimonials() {
            fetch('/admin/testimonials')
                .then(response => response.json())
                .then(testimonials => {
                    const container = document.getElementById('testimonials-container');
                    if (testimonials.length === 0) {
                        container.innerHTML = `
                            <div class="text-center py-5">
                                <i class="fas fa-quote-left text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No testimonials found</h5>
                                <p class="text-muted">Start by adding your first testimonial.</p>
                            </div>
                        `;
                        return;
                    }

                    container.innerHTML = `
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Donor</th>
                                        <th>Content</th>
                                        <th>Rating</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${testimonials.map(testimonial => `
                                        <tr>
                                            <td>
                                                <div>
                                                    <div class="fw-semibold">${testimonial.donor_name}</div>
                                                    <div class="text-muted small">${testimonial.donor_title || 'No title'}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div style="max-width: 300px;">
                                                    ${testimonial.content.length > 100 ? testimonial.content.substring(0, 100) + '...' : testimonial.content}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-warning">
                                                    ${'★'.repeat(testimonial.rating)}${'☆'.repeat(5 - testimonial.rating)}
                                                </div>
                                            </td>
                                            <td>
                                                ${testimonial.is_featured ? '<span class="badge bg-warning me-1">Featured</span>' : ''}
                                                <span class="badge bg-${testimonial.is_active ? 'success' : 'secondary'}">
                                                    ${testimonial.is_active ? 'Active' : 'Inactive'}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="editTestimonial(${testimonial.id})" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteTestimonial(${testimonial.id}, '${testimonial.donor_name}')" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                })
                .catch(error => {
                    console.error('Error loading testimonials:', error);
                    document.getElementById('testimonials-container').innerHTML = 
                        '<div class="alert alert-danger">Failed to load testimonials.</div>';
                });
        }

        function addTestimonial() {
            // Reset form
            document.getElementById('testimonialForm').reset();
            document.getElementById('testimonial_id').value = '';
            document.getElementById('testimonialModalLabel').innerHTML = '<i class="fas fa-quote-left me-2"></i>Add Testimonial';
            
            const modal = new bootstrap.Modal(document.getElementById('testimonialModal'));
            modal.show();
        }

        function editTestimonial(testimonialId) {
            fetch(`/admin/testimonials/${testimonialId}`)
                .then(response => response.json())
                .then(testimonial => {
                    document.getElementById('testimonial_id').value = testimonial.id;
                    document.getElementById('donor_name').value = testimonial.donor_name;
                    document.getElementById('donor_title').value = testimonial.donor_title || '';
                    document.getElementById('content').value = testimonial.content;
                    document.getElementById('rating').value = testimonial.rating;
                    document.getElementById('is_featured').checked = testimonial.is_featured;
                    document.getElementById('is_active').checked = testimonial.is_active;
                    
                    document.getElementById('testimonialModalLabel').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Testimonial';
                    
                    const modal = new bootstrap.Modal(document.getElementById('testimonialModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Error loading testimonial:', error);
                    showAlert('danger', 'Failed to load testimonial details.');
                });
        }

        function saveTestimonial() {
            const form = document.getElementById('testimonialForm');
            const formData = new FormData(form);
            const testimonialId = document.getElementById('testimonial_id').value;
            
            const url = testimonialId ? `/admin/testimonials/${testimonialId}` : '/admin/testimonials';
            const method = testimonialId ? 'PUT' : 'POST';
            
            if (method === 'PUT') {
                formData.append('_method', 'PUT');
            }
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            }

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('testimonialModal'));
                    modal.hide();
                    showAlert('success', data.message);
                    loadTestimonials();
                } else {
                    showAlert('danger', data.message || 'An error occurred.');
                }
            })
            .catch(error => {
                console.error('Error saving testimonial:', error);
                showAlert('danger', 'An error occurred while saving the testimonial.');
            });
        }

        function deleteTestimonial(testimonialId, donorName) {
            if (confirm(`Are you sure you want to delete the testimonial from "${donorName}"?`)) {
                const formData = new FormData();
                formData.append('_method', 'DELETE');
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    formData.append('_token', csrfToken.getAttribute('content'));
                }

                fetch(`/admin/testimonials/${testimonialId}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        loadTestimonials();
                    } else {
                        showAlert('danger', data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error deleting testimonial:', error);
                    showAlert('danger', 'An error occurred while deleting the testimonial.');
                });
            }
        }

        // Settings Management
        function loadSettings() {
            fetch('/admin/settings/api')
                .then(response => response.json())
                .then(settings => {
                    const container = document.getElementById('settings-container');
                    
                    container.innerHTML = `
                        <form id="settingsForm">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3"><i class="fas fa-image me-2"></i>Hero Section</h5>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Hero Title</label>
                                                        <input type="text" class="form-control" name="settings[hero_title]" 
                                                               value="${settings.hero_title || 'Streamline Your Donation Management'}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Hero Background Image URL</label>
                                                        <input type="url" class="form-control" name="settings[hero_background]" 
                                                               value="${settings.hero_background || ''}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Hero Subtitle</label>
                                                <textarea class="form-control" name="settings[hero_subtitle]" rows="3">${settings.hero_subtitle || 'Help nonprofits and charities efficiently track, manage, and optimize their donation processes.'}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-3"><i class="fas fa-video me-2"></i>Demo Video</h5>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Demo Video Title</label>
                                                        <input type="text" class="form-control" name="settings[demo_video_title]" 
                                                               value="${settings.demo_video_title || 'See How It Works'}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label class="form-label">Demo Video URL</label>
                                                        <div class="input-group">
                                                            <input type="url" class="form-control" name="settings[demo_video_url]" 
                                                                   id="demo_video_url"
                                                                   value="${settings.demo_video_url || ''}" 
                                                                   placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                                                            <button type="button" class="btn btn-outline-secondary" onclick="testVideoEmbed()">
                                                                <i class="fas fa-play"></i> Test
                                                            </button>
                                                        </div>
                                                        <div class="form-text">
                                                            <small><strong>Supported YouTube URL formats:</strong>
                                                                <br>• https://www.youtube.com/watch?v=VIDEO_ID
                                                                <br>• https://youtu.be/VIDEO_ID
                                                                <br>• https://www.youtube.com/embed/VIDEO_ID
                                                                <br><br><strong>⚠️ Important:</strong> Some videos cannot be embedded due to copyright or privacy restrictions. If a video shows "Video unavailable", try a different video or use videos marked as "embeddable" in YouTube.
                                                            </small>
                                                        </div>
                                                        <div id="video-test-result" class="mt-2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="text-end">
                                <button type="button" class="btn btn-primary" onclick="saveSettings()">
                                    <i class="fas fa-save me-2"></i>Save Settings
                                </button>
                            </div>
                        </form>
                    `;
                })
                .catch(error => {
                    console.error('Error loading settings:', error);
                    document.getElementById('settings-container').innerHTML = 
                        '<div class="alert alert-danger">Failed to load settings.</div>';
                });
        }

        function saveSettings() {
            const form = document.getElementById('settingsForm');
            const formData = new FormData(form);
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                formData.append('_token', csrfToken.getAttribute('content'));
            }

            fetch('/admin/settings', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                } else {
                    showAlert('danger', data.message || 'An error occurred.');
                }
            })
            .catch(error => {
                console.error('Error saving settings:', error);
                showAlert('danger', 'An error occurred while saving settings.');
            });
        }

        function initializeDefaultSettings() {
            if (confirm('This will reset all settings to default values. Are you sure?')) {
                fetch('/admin/settings/initialize', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showAlert('success', data.message);
                        loadSettings();
                    } else {
                        showAlert('danger', data.message || 'An error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Error initializing settings:', error);
                    showAlert('danger', 'An error occurred while initializing settings.');
                });
            }
        }

        // Video embed testing
        function testVideoEmbed() {
            const videoUrl = document.getElementById('demo_video_url').value;
            const resultDiv = document.getElementById('video-test-result');
            
            if (!videoUrl) {
                resultDiv.innerHTML = '<div class="alert alert-warning alert-sm">Please enter a video URL first.</div>';
                return;
            }
            
            resultDiv.innerHTML = '<div class="alert alert-info alert-sm"><i class="fas fa-spinner fa-spin me-2"></i>Testing video embedding...</div>';
            
            // Convert URL to embed format
            const embedUrl = convertVideoToEmbedUrl(videoUrl);
            
            // Create a test iframe
            const testIframe = document.createElement('iframe');
            testIframe.src = embedUrl + '?enablejsapi=1';
            testIframe.style.width = '200px';
            testIframe.style.height = '113px';
            testIframe.style.border = 'none';
            testIframe.frameborder = '0';
            
            let testPassed = false;
            
            testIframe.onload = function() {
                setTimeout(() => {
                    if (!testPassed) {
                        try {
                            // If we can access the iframe, it likely loaded successfully
                            const rect = testIframe.getBoundingClientRect();
                            if (rect.height > 50) {
                                testPassed = true;
                                resultDiv.innerHTML = `
                                    <div class="alert alert-success alert-sm">
                                        <i class="fas fa-check-circle me-2"></i>Video can be embedded successfully!
                                        <div class="mt-2">${testIframe.outerHTML}</div>
                                    </div>
                                `;
                            } else {
                                showEmbedError(resultDiv, videoUrl);
                            }
                        } catch (e) {
                            // Cross-origin restrictions are normal for YouTube
                            testPassed = true;
                            resultDiv.innerHTML = `
                                <div class="alert alert-success alert-sm">
                                    <i class="fas fa-check-circle me-2"></i>Video appears to be embeddable!
                                    <div class="mt-2">${testIframe.outerHTML}</div>
                                </div>
                            `;
                        }
                    }
                }, 2000);
            };
            
            testIframe.onerror = function() {
                showEmbedError(resultDiv, videoUrl);
            };
            
            // Set a timeout for the test
            setTimeout(() => {
                if (!testPassed) {
                    showEmbedError(resultDiv, videoUrl);
                }
            }, 5000);
        }

        function showEmbedError(resultDiv, videoUrl) {
            resultDiv.innerHTML = `
                <div class="alert alert-danger alert-sm">
                    <i class="fas fa-exclamation-triangle me-2"></i>This video cannot be embedded due to restrictions.
                    <br><small>Try a different video or <a href="${videoUrl}" target="_blank">check the original video</a> for embedding permissions.</small>
                </div>
            `;
        }

        function convertVideoToEmbedUrl(url) {
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

        // Campaign Management Functions
        function viewCampaign(campaignId) {
            // Redirect to campaign details page
            window.open(`/campaigns/${campaignId}`, '_blank');
        }
        
        function approveCampaign(campaignId, campaignName) {
            if (confirm(`Are you sure you want to approve the campaign "${campaignName}"?`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/campaigns/${campaignId}/approve`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    form.appendChild(csrfInput);
                }
                
                document.body.appendChild(form);
                form.submit();
            }
        }
        
        function rejectCampaign(campaignId, campaignName) {
            // Set campaign details in modal
            document.getElementById('reject_campaign_id').value = campaignId;
            document.getElementById('rejectCampaignName').textContent = campaignName;
            document.getElementById('rejection_reason').value = '';
            
            // Show modal
            const modal = new bootstrap.Modal(document.getElementById('campaignRejectModal'));
            modal.show();
        }
        
        function submitCampaignRejection() {
            const campaignId = document.getElementById('reject_campaign_id').value;
            const reason = document.getElementById('rejection_reason').value.trim();
            
            if (reason.length < 10) {
                alert('Rejection reason must be at least 10 characters long.');
                return;
            }
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/campaigns/${campaignId}/reject`;
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Add rejection reason
            const reasonInput = document.createElement('input');
            reasonInput.type = 'hidden';
            reasonInput.name = 'rejection_reason';
            reasonInput.value = reason;
            form.appendChild(reasonInput);
            
            document.body.appendChild(form);
            form.submit();
        }
        
        function deleteCampaign(campaignId, campaignName) {
            if (confirm(`Are you sure you want to delete the campaign "${campaignName}"? This action cannot be undone.`)) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/campaigns/${campaignId}`;
                
                // Add CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (csrfToken) {
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = csrfToken.getAttribute('content');
                    form.appendChild(csrfInput);
                }
                
                // Add method field for DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);
                
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Tab change handlers
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
            tabButtons.forEach(button => {
                button.addEventListener('shown.bs.tab', function(e) {
                    const target = e.target.getAttribute('data-bs-target');
                    if (target === '#pills-testimonials') {
                        loadTestimonials();
                    } else if (target === '#pills-settings') {
                        loadSettings();
                    }
                });
            });
        });

        // Helper function for alerts (if needed)
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.role = 'alert';
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.container').insertAdjacentElement('afterbegin', alertDiv);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }
    </script>
</body>
</html>