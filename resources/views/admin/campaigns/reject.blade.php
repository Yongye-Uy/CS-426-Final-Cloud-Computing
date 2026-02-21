<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reject Campaign - Admin Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #2C3E50;
            --accent-color: #18BC9C;
            --danger-color: #e74c3c;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8fafc;
        }
        
        .reject-header {
            background: linear-gradient(135deg, var(--danger-color), #c0392b);
            color: white;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
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

    <!-- Reject Header -->
    <section class="reject-header mt-5 pt-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-6 fw-bold mb-3">
                        <i class="fas fa-times-circle me-3"></i>Reject Campaign
                    </h1>
                    <p class="lead mb-0">Provide feedback to help improve the campaign</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-light btn-lg">
                        <i class="fas fa-arrow-left me-2"></i>Back to Campaign
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <div class="mb-4">
                        <h4 class="mb-3">Campaign: {{ $campaign->name }}</h4>
                        <p class="text-muted">Created by {{ $campaign->creator ? $campaign->creator->name : 'Unknown' }} on {{ $campaign->created_at->format('M j, Y') }}</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h6 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.campaigns.reject', $campaign) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="rejection_reason" class="form-label fw-bold">
                                <i class="fas fa-comment-alt me-2"></i>Rejection Reason *
                            </label>
                            <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="6" 
                                      minlength="10" maxlength="1000" required 
                                      placeholder="Please provide a clear explanation of why this campaign is being rejected. Be specific and constructive to help the creator improve their submission.">{{ old('rejection_reason') }}</textarea>
                            <div class="form-text">
                                Minimum 10 characters. Be specific and helpful - this will be shown to the campaign creator.
                            </div>
                        </div>

                        <div class="alert alert-warning">
                            <h6 class="fw-bold"><i class="fas fa-info-circle me-2"></i>Important Notes:</h6>
                            <ul class="mb-0">
                                <li>The campaign creator will receive this feedback via email</li>
                                <li>They can edit and resubmit their campaign based on your feedback</li>
                                <li>Be constructive and specific to help them improve</li>
                                <li>Common rejection reasons: unclear goals, insufficient description, inappropriate content</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ route('admin.campaigns.show', $campaign) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-danger btn-lg" onclick="return confirm('Are you sure you want to reject this campaign?')">
                                <i class="fas fa-times me-2"></i>Reject Campaign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
