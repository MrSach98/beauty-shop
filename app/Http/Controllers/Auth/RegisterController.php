<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // Register Form Show
    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.register');
    }

    // Register Submit
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'required|digits:10',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Naam daalna zaroori hai',
            'email.required'     => 'Email daalna zaroori hai',
            'email.unique'       => 'Ye email pehle se registered hai',
            'phone.required'     => 'Phone number daalna zaroori hai',
            'phone.digits'       => 'Phone number 10 digits ka hona chahiye',
            'password.required'  => 'Password daalna zaroori hai',
            'password.min'       => 'Password kam se kam 6 characters ka hona chahiye',
            'password.confirmed' => 'Dono passwords match nahi kar rahe',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('home')
                         ->with('success', 'Account ban gaya! Welcome ' . $user->name);
    }
}