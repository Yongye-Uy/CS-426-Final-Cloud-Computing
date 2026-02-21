<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campaign Details - Admin Dashboard</title>
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
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
        }
        
        .campaign-header {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 1.5rem;
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
        }
        
        .status-approved {
            background: #d1edff;
            color: #0c5460;
        }
        
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
        
        .action-btn {
            margin: 0.25rem;
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: var(--primary-color) !important;
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
                    @auth
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                                <span class="badge bg-warning text-dark ms-1">Admin</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
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

    <!-- Campaign Header -->
    <section class="campaign-header mt-5 pt-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-6 fw-bold mb-3">{{ $campaign->name }}</h1>
                    <p class="lead mb-0">Campaign Review & Management</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back to Campaigns
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

        <div class="row">
            <!-- Campaign Details -->
            <div class="col-lg-8">
                <div class="info-card">
                    <h4 class="mb-4">Campaign Information</h4>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Status:</div>
                        <div class="col-sm-9">
                            <span class="status-badge status-{{ $campaign->approval_status }}">
                                {{ ucfirst($campaign->approval_status) }}
                            </span>
                            @if($campaign->isApproved())
                                <span class="badge bg-success ms-2">{{ ucfirst($campaign->status) }}</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Creator:</div>
                        <div class="col-sm-9">
                            <i class="fas fa-user-circle me-2"></i>
                            {{ $campaign->creator ? $campaign->creator->name : 'Unknown' }}
                            @if($campaign->creator)
                                <small class="text-muted">({{ $campaign->creator->email }})</small>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Goal Amount:</div>
                        <div class="col-sm-9">${{ number_format($campaign->goal_amount, 2) }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Raised Amount:</div>
                        <div class="col-sm-9">
                            <span class="text-success fw-bold">${{ number_format($campaign->raised_amount, 2) }}</span>
                            <small class="text-muted">({{ $campaign->progress_percentage }}% of goal)</small>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Duration:</div>
                        <div class="col-sm-9">
                            {{ $campaign->start_date->format('M j, Y') }} - {{ $campaign->end_date->format('M j, Y') }}
                            @if($campaign->end_date->isFuture())
                                <span class="badge bg-warning text-dark ms-2">{{ floor(abs($campaign->end_date->diffInDays())) }} days remaining</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Created:</div>
                        <div class="col-sm-9">{{ $campaign->created_at->format('M j, Y \a\t g:i A') }}</div>
                    </div>
                    
                    @if($campaign->video_url)
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Video:</div>
                            <div class="col-sm-9">
                                <a href="{{ $campaign->video_url }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-play me-2"></i>View Campaign Video
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    @if($campaign->image_url)
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Image:</div>
                            <div class="col-sm-9">
                                <img src="{{ $campaign->image_url }}" alt="Campaign Image" class="img-thumbnail" style="max-width: 200px;">
                            </div>
                        </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-sm-3 fw-bold">Description:</div>
                        <div class="col-sm-9">
                            <p class="mb-0">{{ $campaign->description }}</p>
                        </div>
                    </div>
                    
                    @if($campaign->isRejected() && $campaign->rejection_reason)
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold text-danger">Rejection Reason:</div>
                            <div class="col-sm-9">
                                <div class="alert alert-danger">
                                    {{ $campaign->rejection_reason }}
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if($campaign->approved_at && $campaign->approver)
                        <div class="row mb-3">
                            <div class="col-sm-3 fw-bold">Reviewed By:</div>
                            <div class="col-sm-9">
                                {{ $campaign->approver->name }} on {{ \Carbon\Carbon::parse($campaign->approved_at)->format('M j, Y \a\t g:i A') }}
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Recent Donations -->
                @if($campaign->donations->count() > 0)
                    <div class="info-card">
                        <h4 class="mb-4">Recent Donations</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Donor</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Method</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaign->donations->take(10) as $donation)
                                        <tr>
                                            <td>{{ $donation->donor->full_name }}</td>
                                            <td class="fw-bold text-success">${{ number_format($donation->amount, 2) }}</td>
                                            <td>{{ $donation->created_at->format('M j, Y') }}</td>
                                            <td><span class="badge bg-light text-dark">{{ ucfirst($donation->payment_method) }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Actions Sidebar -->
            <div class="col-lg-4">
                <div class="info-card">
                    <h5 class="mb-4">Actions</h5>
                    
                    @if($campaign->isPending())
                        <div class="d-grid gap-2 mb-3">
                            <form action="{{ route('admin.campaigns.approve', $campaign) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to approve this campaign?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-lg w-100">
                                    <i class="fas fa-check me-2"></i>Approve Campaign
                                </button>
                            </form>
                        </div>
                        
                        <div class="d-grid gap-2 mb-3">
                            <a href="{{ route('admin.campaigns.reject-form', $campaign) }}" class="btn btn-danger btn-lg">
                                <i class="fas fa-times me-2"></i>Reject Campaign
                            </a>
                        </div>
                    @endif
                    
                    @if($campaign->isApproved())
                        <div class="mb-3">
                            <label for="campaignStatus" class="form-label fw-bold">Campaign Status</label>
                            <form action="{{ route('admin.campaigns.update-status', $campaign) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <select name="status" id="campaignStatus" class="form-select">
                                        <option value="active" {{ $campaign->status === 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="paused" {{ $campaign->status === 'paused' ? 'selected' : '' }}>Paused</option>
                                        <option value="completed" {{ $campaign->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $campaign->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-outline-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    @endif
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.campaigns.destroy', $campaign) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this campaign? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Delete Campaign
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Campaign Stats -->
                <div class="info-card">
                    <h5 class="mb-4">Statistics</h5>
                    
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="fw-bold text-success h4">${{ number_format($campaign->raised_amount) }}</div>
                            <small class="text-muted">Total Raised</small>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="fw-bold h4">{{ $campaign->donations->count() }}</div>
                            <small class="text-muted">Total Donors</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold h4">{{ $campaign->progress_percentage }}%</div>
                            <small class="text-muted">Progress</small>
                        </div>
                        <div class="col-6">
                            <div class="fw-bold h4">${{ number_format($campaign->donations->avg('amount') ?? 0) }}</div>
                            <small class="text-muted">Avg. Donation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
