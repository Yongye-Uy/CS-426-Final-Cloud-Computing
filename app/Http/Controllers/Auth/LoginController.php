<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Find user first to check verification status
        $user = User::where('email', $credentials['email'])->first();

        if ($user && !$user->is_verified) {
            // Auto-resend a new verification code
            $verificationCode = $user->generateVerificationCode();
            Mail::to($user->email)->send(new VerificationCodeMail($user, $verificationCode));

            return redirect()->route('register')
                ->withErrors(['verification' => 'Your email is not verified yet. A new verification code has been sent to your email.'])
                ->withInput(['email' => $credentials['email']]);
        }

        // Block admin users from logging in to frontend
        if ($user && $user->isAdmin()) {
            return redirect()->back()
                ->withErrors(['email' => 'Admin accounts cannot access this application.'])
                ->withInput();
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Welcome back!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'The provided credentials do not match our records.'])
            ->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'You have been logged out successfully.');
    }
}
