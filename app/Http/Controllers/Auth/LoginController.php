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
            'email.required'    => 'Email daalna zaroori hai',
            'email.email'       => 'Valid email daalo',
            'password.required' => 'Password daalna zaroori hai',
            'password.min'      => 'Password kam se kam 6 characters ka hona chahiye',
        ]);

        $credentials = $request->only('email', 'password');
        $remember    = $request->has('remember');

        // Check user active hai ya nahi
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->is_active) {
            return back()->withErrors([
                'email' => 'Aapka account block kar diya gaya hai. Admin se contact karo.'
            ])->withInput();
        }

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return $this->redirectByRole();
        }

        return back()->withErrors([
            'email' => 'Email ya Password is Wrong.',
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