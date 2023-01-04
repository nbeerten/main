<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Middleware for validating captcha.
 */
class ValidateCaptcha
{
    /**
     * Validate the captcha
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Check if method is post, and if the route isnt the logout route
        if ($request->routeIs('logout') || ! $request->isMethod('post')) {
            return $next($request);
        }

        $validator = Validator::make($request->all(), [
            'cf-turnstile-response' => ['required', Rule::turnstile()],
        ]);

        if ($validator->fails()) {
            return back()
                   ->withErrors($validator->errors())
                   ->withInput($request->except('cf-turnstile-response'));
        }

        return $next($request);
    }
}
