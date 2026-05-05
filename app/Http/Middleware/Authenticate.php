<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function handle($request, Closure $next,...$guards)
    {
        #if user is logged in
        if(Auth::check())
        {
            #if user is blocked | logout the user
            if(!auth()->user()->isActive()){
                session()->flash('status', 'You have been blocked. Contact Admin For more information');
                Auth::logoutCurrentDevice();
            }else{
                return $next($request);
            }
        }
        # save the URL the user was trying to access
        session()->put('url.intended', $request->url());
        #redirect to User login page
        return redirect()->route('login');
    }
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
