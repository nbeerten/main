<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for validating captcha.
 */
class ValidateCaptcha
{
    /**
     * Validate the captcha
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
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
