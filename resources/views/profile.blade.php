<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Donation Tracking System</title>
    <meta name="description" content="Your profile page">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --light-bg: #f8fafc;
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

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            border: none;
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
    <nav class="navbar">
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
                        @if(Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                        @endif
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
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Profile Header -->
    <div class="profile-header">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">
                <i class="fas fa-user-circle me-3"></i>User Profile
            </h1>
            <p class="lead mb-0">Manage your account information and preferences</p>
        </div>
    </div>

    <!-- Profile Content -->
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="profile-card">
                    <h4 class="mb-4">Account Information</h4>
                    
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ Auth::user()->name ?? 'Not provided' }}
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ Auth::user()->email ?? 'Not provided' }}
                        </div>
                    </div>

                    @if(isset(Auth::user()->organization) && Auth::user()->organization)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Organization:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ Auth::user()->organization }}
                        </div>
                    </div>
                    @endif

                    @if(isset(Auth::user()->phone) && Auth::user()->phone)
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Phone:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ Auth::user()->phone }}
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Role:</strong>
                        </div>
                        <div class="col-sm-9">
                            @php
                                $isAdmin = Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin();
                            @endphp
                            <span class="badge bg-{{ $isAdmin ? 'warning' : 'primary' }}">
                                {{ Auth::user()->role->name ?? ($isAdmin ? 'Administrator' : 'User') }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Member Since:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ isset(Auth::user()->created_at) ? Auth::user()->created_at->format('F j, Y') : 'N/A' }}
                        </div>
                    </div>

                    <hr class="my-4">

                    @if(!$isAdmin)
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Note:</strong> You have a regular user account. Dashboard access is restricted to administrators only. 
                            If you need administrative access, please contact your system administrator.
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fas fa-crown me-2"></i>
                            <strong>Administrator Access:</strong> You have full access to the donation tracking dashboard and all administrative features.
                        </div>
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        @if($isAdmin)
                            <a href="{{ route('dashboard') }}" class="btn btn-success ms-2">
                                <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (still needed for alerts, etc.) -->
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
</body>
</html>