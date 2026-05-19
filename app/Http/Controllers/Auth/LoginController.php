<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Login Form Show
    public function showForm()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        return view('auth.login');
    }

    // Login Submit
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters long.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->has('remember');

        // Check user active hai ya nahi
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Your account has been blocked. Please contact the admin.'
            ])->withInput();
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Email or Password is incorrect.',
        ])->withInput($request->only('email'));
    }

    // Role ke hisaab se redirect
    private function redirectByRole()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    }
}