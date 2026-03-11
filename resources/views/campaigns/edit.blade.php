<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Campaign - {{ config('app.name', 'Donation Tracker') }}</title>
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
            --light-bg: #f8fafc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--primary-color);
            background: var(--light-bg);
        }
        
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            margin: 2rem 0;
        }
        
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent-color);
        }
        
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(44, 62, 80, 0.3);
        }
        
        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(24, 188, 156, 0.25);
        }
        
        .navbar {
            background: white !important;
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .nav-link {
            color: var(--primary-color) !important;
        }
        
        .help-text {
            background: #e8f5e8;
            border-left: 4px solid var(--success-color);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0 10px 10px 0;
        }
        
        .character-count {
            font-size: 0.875rem;
            color: #6c757d;
            text-align: right;
        }
        
        .status-info {
            background: #f8f9fa;
            border-left: 4px solid var(--accent-color);
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 0 10px 10px 0;
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
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle btn btn-outline-primary" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
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

    <!-- Main Content -->
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="display-6 fw-bold text-primary">
                            <i class="fas fa-edit me-3"></i>Edit Campaign
                        </h2>
                        <p class="lead text-muted">Update your campaign details</p>
                    </div>

                    <div class="status-info">
                        <h6 class="fw-bold text-primary"><i class="fas fa-info-circle me-2"></i>Campaign Status</h6>
                        <p class="mb-2">
                            Current Status: 
                            <span class="badge 
                                @if($campaign->isPending()) bg-warning text-dark
                                @elseif($campaign->isApproved()) bg-success
                                @else bg-danger
                                @endif">
                                {{ ucfirst($campaign->approval_status) }}
                            </span>
                        </p>
                        @if($campaign->isRejected() && $campaign->rejection_reason)
                            <div class="alert alert-danger mt-2">
                                <strong>Rejection Reason:</strong> {{ $campaign->rejection_reason }}
                            </div>
                        @endif
                        @if($campaign->isRejected())
                            <small class="text-muted">Making changes will reset your campaign to "Pending" status for admin review.</small>
                        @endif
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

                    <form action="{{ route('campaigns.update', $campaign) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="name" class="form-label fw-bold">Campaign Name *</label>
                                <input type="text" class="form-control form-control-lg" id="name" name="name" 
                                       value="{{ old('name', $campaign->name) }}" maxlength="255" required>
                                <div class="character-count">
                                    <span id="name-count">{{ strlen($campaign->name) }}</span>/255 characters
                                </div>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="goal_amount" class="form-label fw-bold">Funding Goal ($) *</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="goal_amount" name="goal_amount" 
                                           value="{{ old('goal_amount', $campaign->goal_amount) }}" min="100" step="0.01" required>
                                </div>
                                <small class="text-muted">Minimum goal: $100</small>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="start_date" class="form-label fw-bold">Start Date *</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="{{ old('start_date', $campaign->start_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="end_date" class="form-label fw-bold">End Date *</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="{{ old('end_date', $campaign->end_date->format('Y-m-d')) }}" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="video_url" class="form-label fw-bold">Campaign Video (Optional)</label>
                                <input type="url" class="form-control" id="video_url" name="video_url" 
                                       value="{{ old('video_url', $campaign->video_url) }}" placeholder="https://youtube.com/watch?v=...">
                                <small class="text-muted">YouTube or Vimeo URL</small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="image_url" class="form-label fw-bold">Campaign Image (Optional)</label>
                                <input type="url" class="form-control" id="image_url" name="image_url" 
                                       value="{{ old('image_url', $campaign->image_url) }}" placeholder="https://example.com/image.jpg">
                                <small class="text-muted">Direct link to your campaign image</small>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label for="description" class="form-label fw-bold">Campaign Description *</label>
                                <textarea class="form-control" id="description" name="description" rows="8" 
                                          minlength="50" maxlength="2000" required>{{ old('description', $campaign->description) }}</textarea>
                                <div class="character-count">
                                    <span id="description-count">{{ strlen($campaign->description) }}</span>/2000 characters (minimum 50)
                                </div>
                                <small class="text-muted">Tell your story! Explain what you're raising money for, why it matters, and how donations will be used.</small>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="{{ route('campaigns.my-campaigns') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Update Campaign
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Character counting
        function updateCharacterCount(inputId, countId, maxLength) {
            const input = document.getElementById(inputId);
            const counter = document.getElementById(countId);
            
            function updateCount() {
                const currentLength = input.value.length;
                counter.textContent = currentLength;
                
                if (currentLength > maxLength * 0.9) {
                    counter.style.color = '#e74c3c';
                } else if (currentLength > maxLength * 0.7) {
                    counter.style.color = '#f39c12';
                } else {
                    counter.style.color = '#6c757d';
                }
            }
            
            input.addEventListener('input', updateCount);
            updateCount(); // Initial count
        }
        
        // Initialize character counters
        updateCharacterCount('name', 'name-count', 255);
        updateCharacterCount('description', 'description-count', 2000);
        
        // Date validation
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDateInput = document.getElementById('end_date');
            
            // Set minimum end date to start date + 1 day
            const minEndDate = new Date(startDate);
            minEndDate.setDate(minEndDate.getDate() + 1);
            endDateInput.min = minEndDate.toISOString().split('T')[0];
            
            // Clear end date if it's before start date
            if (endDateInput.value && new Date(endDateInput.value) <= startDate) {
                endDateInput.value = '';
            }
        });
        
        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const description = document.getElementById('description').value;
            if (description.length < 50) {
                e.preventDefault();
                alert('Description must be at least 50 characters long.');
                return;
            }
            
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
            
            if (endDate <= startDate) {
                e.preventDefault();
                alert('End date must be after start date.');
                return;
            }
        });
    </script>
</body>
</html>
