<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Donation Tracking System</title>
    <meta name="description" content="Secure login to your donation tracking dashboard">
    
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
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
        }

        .auth-left {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 3rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .auth-right {
            padding: 3rem;
        }

        .logo {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .form-floating > label {
            color: var(--gray-text);
        }

        .form-control {
            border-radius: 12px;
            padding: 1rem;
            border: 2px solid transparent;
            background: var(--light-bg);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.1);
            background: white;
        }

        .btn-primary {
            background: var(--secondary-color);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(52, 152, 219, 0.3);
        }

        .auth-links a {
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .auth-links a:hover {
            color: var(--primary-color);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }

        .alert {
            border-radius: 12px;
            border: none;
        }

        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }
            .auth-right {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="auth-left">
                        <div class="feature-icon">
                            <i class="fas fa-heart"></i>
                        </div>
                        <h2 class="logo">DonationTracker</h2>
                        <p class="lead mb-4">Empowering organizations to make a difference through transparent donation management</p>
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-users mb-2" style="font-size: 1.5rem;"></i>
                                <div class="small">{{ number_format(App\Models\Donor::count()) }}+ Donors</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-hand-holding-heart mb-2" style="font-size: 1.5rem;"></i>
                                <div class="small">${{ number_format(App\Models\Donation::where('status', 'completed')->sum('amount')) }} Raised</div>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-bullseye mb-2" style="font-size: 1.5rem;"></i>
                                <div class="small">{{ App\Models\Campaign::count() }} Campaigns</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="auth-right">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark">Welcome Back!</h3>
                            <p class="text-muted">Sign in to access your donation dashboard</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @if($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @else
                                    Please correct the errors below.
                                @endif
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" placeholder="name@example.com" 
                                       value="{{ old('email') }}" required>
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                </div>
                                
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </button>
                        </form>

                        <div class="text-center auth-links">
                            <p class="mb-0">Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
                            <p class="mt-2"><a href="{{ route('home') }}">← Back to Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 