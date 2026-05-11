<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                             ->with('error', 'Pehle login karo.');
        }

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Aapko admin panel access karne ki permission nahi hai.');
        }

        return $next($request);
    }
}