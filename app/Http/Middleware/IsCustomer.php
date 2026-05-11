<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Pehle login karo.');
        }

        if (Auth::user()->role !== 'customer') {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}