<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Classes\SEO\Robots;
use App\Classes\SEO\SEO;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function dashboard(Request $request): View
    {
        SEO::share(
            title: 'Dashboard',
            robots: [Robots::NONE]
        );

        return view('auth.dashboard');
    }

    public function login(Request $request): View
    {
        SEO::share(
            title: 'Login',
            robots: [Robots::NONE]
        );

        return view('auth.login');
    }

    public function forgotPassword(Request $request): View
    {
        SEO::share(
            title: 'Forgot password',
            robots: [Robots::NONE]
        );

        return view('auth.forgot-password');
    }

    public function resetPassword(Request $request): View
    {
        SEO::share(
            title: 'Reset password',
            robots: [Robots::NONE]
        );

        return view('auth.reset-password', ['request' => $request]);
    }
}
