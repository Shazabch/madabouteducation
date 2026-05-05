<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicUser
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
        #if user is logged in
        if(Auth::check())
        {
            #if user is blocked | logout the user
            if(!auth()->user()->isActive()){
                session()->flash('status', 'You have been blocked. Contact Admin For more information');
                Auth::logoutCurrentDevice();
            }
            #if logged in user is not admin
            elseif(!auth()->user()->isAdmin())
            {
                return $next($request);
            }
            else{
                abort(404);
            }

        }
        # save the URL the user was trying to access
        session()->put('url.intended', $request->url());
        #redirect to Admin login page
        return redirect()->route('login');
    }
}
