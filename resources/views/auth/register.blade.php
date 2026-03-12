<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Donation Tracking System</title>
    <meta name="description" content="Join our donation tracking platform and make a difference">
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
            max-width: 1200px;
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

        .btn-success {
            background: var(--success-color);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #219a52;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border: 2px solid var(--gray-text);
            color: var(--gray-text);
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: var(--gray-text);
            color: white;
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

        .benefit-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .benefit-item i {
            color: rgba(255,255,255,0.8);
            margin-right: 0.75rem;
            width: 20px;
        }

        .verification-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            border: 2px solid #e9ecef;
            display: none;
        }

        .verification-section.show {
            display: block;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .code-input {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
            border: 3px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            transition: all 0.3s ease;
        }

        .code-input:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .timer {
            font-size: 16px;
            font-weight: bold;
            color: var(--danger-color);
            text-align: center;
            margin: 10px 0;
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .step {
            display: flex;
            align-items: center;
            margin: 0 1rem;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: var(--gray-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 0.5rem;
        }

        .step.active .step-number {
            background: var(--secondary-color);
            color: white;
        }

        .step.completed .step-number {
            background: var(--success-color);
            color: white;
        }

        @media (max-width: 768px) {
            .auth-left {
                display: none;
            }
            .auth-right {
                padding: 2rem 1.5rem;
            }
            .step-indicator {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="auth-left">
                        <div class="feature-icon">
                            <i class="fas fa-hands-helping"></i>
                        </div>
                        <h2 class="logo">Join Us</h2>
                        <p class="lead mb-4">Start tracking donations and making an impact today</p>
                        
                        <div class="text-start w-100">
                            <h5 class="mb-3">Why choose DonationTracker?</h5>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Real-time donation tracking</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-chart-line"></i>
                                <span>Comprehensive analytics</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Secure & encrypted data</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-users"></i>
                                <span>Donor management tools</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-bullseye"></i>
                                <span>Campaign goal tracking</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="auth-right">
                        <!-- Step Indicator -->
                        <div class="step-indicator">
                            <div class="step active" id="step1">
                                <div class="step-number">1</div>
                                <span>Register</span>
                            </div>
                            <div class="step" id="step2">
                                <div class="step-number">2</div>
                                <span>Verify Email</span>
                            </div>
                            <div class="step" id="step3">
                                <div class="step-number">3</div>
                                <span>Complete</span>
                            </div>
                        </div>

                        <div class="text-center mb-4">
                            <h3 class="fw-bold text-dark">Create Your Account</h3>
                            <p class="text-muted">Join thousands of organizations making a difference</p>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                @foreach($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif

                        <!-- Check if user needs verification -->
                        @php
                            $needsVerification = false;
                            $userEmail = old('email');
                            if ($errors->has('verification') || $errors->has('email')) {
                                foreach ($errors->all() as $error) {
                                    if (str_contains($error, 'verify') || str_contains($error, 'verification')) {
                                        $needsVerification = true;
                                        break;
                                    }
                                }
                            }
                        @endphp

                        <!-- Registration Form -->
                        <form method="POST" action="{{ route('register') }}" id="registrationForm" style="{{ $needsVerification ? 'display: none;' : '' }}">
                            @csrf
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" name="name" 
                                               placeholder="Full Name" value="{{ old('name') }}" required>
                                        <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="email" name="email" 
                                               placeholder="Email Address" value="{{ old('email') }}" required>
                                        <label for="email"><i class="fas fa-envelope me-2"></i>Email Address</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password" name="password" 
                                               placeholder="Password" required>
                                        <label for="password"><i class="fas fa-lock me-2"></i>Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" id="password_confirmation" 
                                               name="password_confirmation" placeholder="Confirm Password" required>
                                        <label for="password_confirmation"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="organization" name="organization" 
                                               placeholder="Organization (Optional)" value="{{ old('organization') }}">
                                        <label for="organization"><i class="fas fa-building me-2"></i>Organization (Optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               placeholder="Phone Number (Optional)" value="{{ old('phone') }}">
                                        <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number (Optional)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg" id="registerBtn">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>
                            </div>
                        </form>

                        <!-- Verification Section -->
                        <div class="verification-section {{ $needsVerification ? 'show' : '' }}" id="verificationSection">
                            <div class="text-center mb-4">
                                <div class="feature-icon text-primary">
                                    <i class="fas fa-envelope-open"></i>
                                </div>
                                <h4 class="fw-bold text-primary">Verify Your Email</h4>
                                <p class="text-muted">Enter the verification code sent to your email address</p>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Check your email: <strong id="userEmail">{{ $userEmail ?: 'your-email@example.com' }}</strong>
                                </div>
                            </div>

                            <form id="verificationForm" method="POST" action="{{ route('register.verify.post') }}">
                                @csrf
                                <input type="hidden" id="hiddenUserId" name="user_id" value="">
                                <div class="mb-3">
                                    <label for="verification_code" class="form-label">
                                        <i class="fas fa-key me-2"></i>Verification Code
                                    </label>
                                    <input type="text" 
                                           class="form-control code-input" 
                                           id="verification_code" 
                                           name="verification_code" 
                                           placeholder="000000"
                                           maxlength="6"
                                           pattern="[0-9]{6}"
                                           required
                                           autocomplete="off">
                                    <small class="text-muted">Enter the 6-digit code from your email</small>
                                    <div class="timer mt-2" id="timer">Code expires in: <span id="countdown">15:00</span></div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success w-100" id="verifyBtn">
                                            <i class="fas fa-check-circle me-2"></i>Verify Email
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-secondary w-100" id="resendBtn">
                                            <i class="fas fa-redo me-2"></i>Resend Code
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-3">
                                <button type="button" class="btn btn-link" onclick="showRegistrationForm()">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Registration
                                </button>
                            </div>
                        </div>

                        <div class="text-center mt-4 auth-links">
                            <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        let timeLeft = 15 * 60; // 15 minutes in seconds
        let countdownInterval;
        let pendingUserId = null;

        // Check if we need to show verification on page load
        @if($needsVerification && $userEmail)
            document.addEventListener('DOMContentLoaded', function() {
                // Try to find the user by email to get verification
                findUserForVerification('{{ $userEmail }}');
            });
        @endif

        // Handle registration form submission
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const registerBtn = document.getElementById('registerBtn');
            registerBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
            registerBtn.disabled = true;

            const formData = new FormData(this);
            
            // Convert FormData to JSON object
            const jsonData = {};
            for (let [key, value] of formData.entries()) {
                jsonData[key] = value;
            }
            
            // Debug: Log form data
            console.log('Form submission started...');
            console.log('Form data as JSON:', jsonData);
            
            fetch('{{ route("register") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(jsonData)
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
                    }).catch(parseError => {
                        if (parseError.message && !parseError.message.includes('HTTP error')) {
                            throw parseError;
                        }
                        throw new Error(`HTTP error! status: ${response.status}`);
                    });
                }

                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    // Show verification section
                    document.getElementById('userEmail').textContent = jsonData.email;
                    document.getElementById('verificationSection').classList.add('show');
                    
                    // Update step indicator
                    document.getElementById('step1').classList.add('completed');
                    document.getElementById('step1').classList.remove('active');
                    document.getElementById('step2').classList.add('active');
                    
                    // Start countdown timer
                    startCountdown();
                    
                    // Store user ID for verification
                    pendingUserId = data.user_id;
                    document.getElementById('hiddenUserId').value = data.user_id;
                    
                    // Hide registration form
                    document.getElementById('registrationForm').style.display = 'none';
                    
                    // Show success message
                    showAlert('success', 'Registration successful! Please check your email for the verification code.');
                } else {
                    // Show errors
                    console.log('Registration failed:', data);
                    if (data.errors) {
                        let errorMessage = '';
                        for (let field in data.errors) {
                            errorMessage += data.errors[field].join(', ') + '<br>';
                        }
                        showAlert('danger', errorMessage);
                    } else {
                        showAlert('danger', data.message || 'Registration failed. Please try again.');
                    }
                    registerBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account';
                    registerBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                showAlert('danger', 'An error occurred. Please try again. Error: ' + error.message);
                registerBtn.innerHTML = '<i class="fas fa-user-plus me-2"></i>Create Account';
                registerBtn.disabled = false;
            });
        });

        // Handle verification form submission (regular form POST, not fetch)
        document.getElementById('verificationForm').addEventListener('submit', function(e) {
            const code = document.getElementById('verification_code').value;
            const userId = document.getElementById('hiddenUserId').value || pendingUserId;

            if (code.length !== 6 || !/^\d{6}$/.test(code)) {
                e.preventDefault();
                showAlert('danger', 'Please enter a valid 6-digit verification code.');
                return;
            }

            if (!userId) {
                e.preventDefault();
                showAlert('danger', 'User ID not found. Please try registering again.');
                return;
            }

            // Set user_id in hidden field and let the form submit normally
            document.getElementById('hiddenUserId').value = userId;
            document.getElementById('verifyBtn').innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Verifying...';
            document.getElementById('verifyBtn').disabled = true;
            // Form submits as a regular POST — server handles redirect
        });

        // Handle resend code
        document.getElementById('resendBtn').addEventListener('click', function() {
            const resendBtn = this;
            const userId = document.getElementById('hiddenUserId').value || pendingUserId;

            if (!userId) {
                showAlert('danger', 'User ID not found. Please try registering again.');
                return;
            }

            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            resendBtn.disabled = true;

            fetch('{{ route("register.resend") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', 'New verification code sent to your email!');
                    // Reset timer
                    timeLeft = 15 * 60;
                    startCountdown();
                } else {
                    showAlert('danger', data.message || 'Failed to send verification code.');
                }
                resendBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Resend Code';
                resendBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('danger', 'An error occurred. Please try again.');
                resendBtn.innerHTML = '<i class="fas fa-redo me-2"></i>Resend Code';
                resendBtn.disabled = false;
            });
        });

        // Auto-format verification code input
        document.getElementById('verification_code').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '');
            
            if (this.value.length === 6) {
                setTimeout(() => {
                    document.getElementById('verificationForm').requestSubmit();
                }, 500);
            }
        });

        // Countdown timer
        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            const resendBtn = document.getElementById('resendBtn');
            
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            
            countdownInterval = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                countdownElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(countdownInterval);
                    countdownElement.parentElement.innerHTML = '<span class="text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Code has expired. Please request a new one.</span>';
                    resendBtn.classList.add('btn-warning');
                    resendBtn.classList.remove('btn-outline-secondary');
                } else {
                    timeLeft--;
                }
            }, 1000);
        }

        // Show alert function
        function showAlert(type, message) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            const container = document.querySelector('.auth-right');
            container.insertBefore(alertDiv, container.firstChild);
            
            setTimeout(() => {
                alertDiv.remove();
            }, 5000);
        }

        // Show registration form (hide verification)
        function showRegistrationForm() {
            document.getElementById('registrationForm').style.display = 'block';
            document.getElementById('verificationSection').classList.remove('show');
            
            // Reset step indicator
            document.getElementById('step1').classList.add('active');
            document.getElementById('step1').classList.remove('completed');
            document.getElementById('step2').classList.remove('active');
            document.getElementById('step3').classList.remove('active');
            
            // Clear verification code
            document.getElementById('verification_code').value = '';
            
            // Clear timer
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        }

        // Find user for verification (for existing users)
        function findUserForVerification(email) {
            fetch('{{ route("register.find-user") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    pendingUserId = data.user_id;
                    document.getElementById('hiddenUserId').value = data.user_id;
                    showAlert('info', 'Please enter your verification code or click "Resend Code" to get a new one.');
                    startCountdown();
                } else {
                    if (data.redirect) {
                        showAlert('info', data.message + ' Redirecting to login...');
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 2000);
                    } else {
                        showAlert('warning', data.message);
                        showRegistrationForm();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('warning', 'Could not find user. Please try registering again.');
                showRegistrationForm();
            });
        }
    </script>
</body>
</html> 