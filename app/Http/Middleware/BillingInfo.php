<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class BillingInfo {

    /**
     * The Guard implementation.
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //when request is not logout or not registration
        if (($this->auth->check() && !(($request->segment(2) == 'logout') ||
                ($request->segment(1) == 'billing-info'))
        ) && (0 == (auth()->user()->user_type)))
        {
            return redirect('/billing-info');
        }

        return $next($request);
    }
}
