<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }
        
        .content {
            padding: 40px 30px;
            line-height: 1.6;
            color: #2c3e50;
        }
        
        .verification-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            margin: 25px 0;
            letter-spacing: 8px;
            font-family: 'Courier New', monospace;
        }
        
        .info-box {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .warning-box {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        
        .btn {
            display: inline-block;
            background: #2C3E50;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .social-links {
            margin: 15px 0;
        }
        
        .social-links a {
            color: #2C3E50;
            text-decoration: none;
            margin: 0 10px;
        }
        
        @media (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .content {
                padding: 20px 15px;
            }
            
            .verification-code {
                font-size: 24px;
                letter-spacing: 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="icon">🔐</div>
            <h1>{{ config('app.name') }}</h1>
            <p>Email Verification Required</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h2>Hello {{ $user->name }}!</h2>
            
            <p>Thank you for registering with {{ config('app.name') }}! To complete your account setup and ensure the security of your account, please verify your email address using the verification code below.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <div style="background: #f8f9fa; border-radius: 10px; padding: 20px; display: inline-block; font-family: 'Courier New', monospace; font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #2c3e50; border: 3px dashed #3498db;">
                    {{ $verificationCode }}
                </div>
            </div>
            
            <!-- Direct Verification Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" 
                   style="background: #27ae60; color: white; padding: 15px 30px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">
                    &#10004; Verify Email Instantly
                </a>
            </div>
            
            <div style="text-align: center; margin: 20px 0;">
                <p style="color: #7f8c8d; font-size: 14px; margin: 5px 0;">
                    <strong>Option 1:</strong> Click the button above for instant verification
                </p>
                <p style="color: #7f8c8d; font-size: 14px; margin: 5px 0;">
                    <strong>Option 2:</strong> Enter the 6-digit code manually on the registration page
                </p>
                <p style="color: #7f8c8d; font-size: 12px; margin: 10px 0;">
                    If the button doesn't work, copy and paste this link: <br>
                    <a href="{{ $verificationUrl }}" style="color: #3498db; word-break: break-all;">{{ $verificationUrl }}</a>
                </p>
            </div>
            
            <div class="info-box">
                <strong>📋 How to use this code:</strong>
                <ul>
                    <li>Go back to the registration page</li>
                    <li>Enter this 6-digit code in the verification field</li>
                    <li>Click "Verify Email" to complete your registration</li>
                </ul>
            </div>
            
            <div class="warning-box">
                <strong>⚠️ Important Security Information:</strong>
                <ul>
                    <li>This code will expire in <strong>15 minutes</strong></li>
                    <li>Do not share this code with anyone</li>
                    <li>If you didn't request this verification, please ignore this email</li>
                    <li>For security, this code can only be used once</li>
                </ul>
            </div>
            
            <p>If you're having trouble with the verification process, you can request a new code or contact our support team.</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('register.verify') }}" class="btn">Complete Verification</a>
            </div>
            
            <p>Welcome to our community! Once verified, you'll be able to:</p>
            <ul>
                <li>✅ Create and manage donation campaigns</li>
                <li>✅ Track your donations and impact</li>
                <li>✅ Connect with other donors and organizations</li>
                <li>✅ Access exclusive features and insights</li>
            </ul>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong> - Donation Management System</p>
            <p>Making a difference, one donation at a time.</p>
            
            <div class="social-links">
                <a href="#">📧 Support</a>
                <a href="#">🌐 Website</a>
                <a href="#">📱 Mobile App</a>
            </div>
            
            <p style="font-size: 12px; color: #999; margin-top: 20px;">
                This email was sent to {{ $user->email }}. If you received this email by mistake, 
                please ignore it. You will not be added to any mailing list.
            </p>
            
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html> 