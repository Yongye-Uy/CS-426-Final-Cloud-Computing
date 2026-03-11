<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;


class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'organization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Get the user role (default role)
            $userRole = Role::where('name', 'user')->first();

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'organization' => $request->organization,
                'phone' => $request->phone,
                'role_id' => $userRole ? $userRole->id : null,
                'is_verified' => false,
            ]);

            // Generate and send verification code
            $verificationCode = $user->generateVerificationCode();
            
            Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));
            
            // Store user ID in session for verification
            Session::put('pending_user_id', $user->id);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Registration successful! Please check your email for the verification code.',
                    'user_id' => $user->id
                ]);
            }
            
            return redirect()->route('register.verify')
                ->with('success', 'Registration successful! Please check your email for the verification code.');
                
        } catch (\Exception $e) {
            // If user was created, delete it
            if (isset($user) && $user->exists) {
                $user->delete();
            }
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registration failed: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['email' => 'Registration failed: ' . $e->getMessage()])
                ->withInput();
        }
    }

    public function showVerificationForm(Request $request)
    {
        // Handle direct email verification links
        $code = $request->get('code');
        $userId = $request->get('user');
        
        if ($code && $userId) {
            // Verify the code directly
            $user = User::find($userId);
            if ($user && !$user->is_verified) {
                if ($user->verifyCode($code)) {
                    Auth::login($user);
                    return redirect()->route('home')
                        ->with('success', 'Email verified successfully! Welcome to ' . config('app.name') . '!');
                } else {
                    return redirect()->route('register')
                        ->withErrors(['verification' => 'Invalid or expired verification code. Please request a new one.'])
                        ->withInput(['email' => $user->email]);
                }
            } else if ($user && $user->is_verified) {
                return redirect()->route('login')
                    ->with('success', 'Account already verified. Please login.');
            }
        }
        
        // Show verification form for manual entry
        return redirect()->route('register')
            ->withErrors(['verification' => 'Please enter your verification code to complete registration.']);
    }

    public function verify(Request $request)
    {
        Log::info('Verification attempt', [
            'request_data' => $request->all(),
            'expects_json' => $request->expectsJson(),
            'headers' => $request->headers->all()
        ]);

        $validator = Validator::make($request->all(), [
            'verification_code' => 'required|string|size:6',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            Log::warning('Verification validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification code format',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()->withErrors($validator);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            Log::error('User not found during verification', ['user_id' => $request->user_id]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            return redirect()->route('register')
                ->withErrors(['error' => 'User not found. Please register again.']);
        }

        Log::info('User found for verification', [
            'user_id' => $user->id,
            'is_verified' => $user->is_verified,
            'has_verification_code' => !empty($user->verification_code),
            'code_expires_at' => $user->verification_code_expires_at
        ]);

        if ($user->is_verified) {
            Log::info('User already verified');

            Auth::login($user);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified',
                    'redirect' => route('home')
                ]);
            }

            return redirect()->route('home')
                ->with('success', 'Account already verified. Welcome back!');
        }

        if ($user->verifyCode($request->verification_code)) {
            Log::info('Verification successful', ['user_id' => $user->id]);
            
            Session::forget('pending_user_id');
            Auth::login($user);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email verified successfully! Welcome to ' . config('app.name') . '!',
                    'redirect' => route('home')
                ]);
            }
            
            return redirect()->route('home')
                ->with('success', 'Email verified successfully! Welcome to ' . config('app.name') . '!');
        } else {
            Log::warning('Verification failed', [
                'user_id' => $user->id,
                'provided_code' => $request->verification_code,
                'stored_code' => $user->verification_code,
                'is_expired' => $user->isVerificationCodeExpired()
            ]);
            
            $message = $user->isVerificationCodeExpired() 
                ? 'Verification code has expired. Please request a new one.'
                : 'Invalid verification code. Please try again.';
                
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 422);
            }
            
            return redirect()->back()->withErrors(['verification_code' => $message]);
        }
    }

    public function resendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid request',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->route('register')
                ->withErrors(['error' => 'Invalid request. Please register again.']);
        }

        $user = User::find($request->user_id);
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }
            
            return redirect()->route('register')
                ->withErrors(['error' => 'User not found. Please register again.']);
        }

        if ($user->is_verified) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Account already verified',
                    'redirect' => route('login')
                ]);
            }
            
            return redirect()->route('login')
                ->with('success', 'Account already verified. Please login.');
        }

        // Generate and send new verification code
        $verificationCode = $user->generateVerificationCode();
        
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'New verification code sent to your email!'
                ]);
            }
            
            return redirect()->back()
                ->with('success', 'New verification code sent to your email!');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send verification email. Please try again.'
                ], 500);
            }
            
            return redirect()->back()
                ->withErrors(['error' => 'Failed to send verification email. Please try again.']);
        }
    }

    public function findUserByEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        if ($user->is_verified) {
            return response()->json([
                'success' => false,
                'message' => 'User is already verified',
                'redirect' => route('login')
            ]);
        }

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'message' => 'User found. You can now verify your email.'
        ]);
    }
}
