<?php

namespace App\Http\Middleware;

use Closure;
use romanzipp\Turnstile;

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
        if ($request->isMethod('post') && ! $request->routeIs('logout')) {
            $token = $request->input('cf-turnstile-response');

            $validator = new Turnstile\Validator();
            $validation = $validator->validate($token);

            if ($validation->isValid()) {
                return $next($request);
            } else {
                return back()->withErrors($validation->getMessage())->withInput($request->except('cf-turnstile-response'));
            }
        } else {
            return $next($request);
        }
    }
}
