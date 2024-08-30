<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user() && auth()->user()->role == 'user') {
            return $next($request);
        }elseif(auth()->user() && auth()->user()->role == 'empty') {
            return $next($request);
        }
        return redirect('posts');
        // return abort(403, 'Halaman yang kamu minta tidak dapat di akses');
        // return redirect('/dashboard');
        // return $next($request);
    }
}
