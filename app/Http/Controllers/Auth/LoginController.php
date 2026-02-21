<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

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
            return redirect()->route('register')
                ->withErrors(['email' => 'Please verify your email address before logging in. Complete your registration by entering the verification code sent to your email.'])
                ->withInput(['email' => $credentials['email']]);
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('/dashboard')->with('success', 'Welcome back, Admin!');
            } else {
                return redirect()->intended('/')->with('success', 'Welcome back!');
            }
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
