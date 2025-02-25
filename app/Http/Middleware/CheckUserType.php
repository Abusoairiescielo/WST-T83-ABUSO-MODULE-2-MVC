<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $userType): Response
    {
        \Log::info('CheckUserType middleware', [
            'user_type' => auth()->user()->user_type ?? 'none',
            'required_type' => $userType,
            'is_authenticated' => auth()->check()
        ]);

        if (!auth()->check()) {
            return redirect('login');
        }
    
        if (auth()->user()->user_type !== $userType) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }
}
