<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;


class PermissionCheck
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
        if($request->session()->has('shuvecha') && (session('shuvecha')->type == 1))
        {
            return $next($request);
        }

        $request->session()->flash('error',"You don't have permission to access this section");
        return redirect()->back();

        return $next($request);
    }
}
