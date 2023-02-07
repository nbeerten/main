<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SEO;
use App\Classes\SEO\SEOData;
use App\Classes\SEO\Robots;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;

class AuthController extends Controller
{
    public function dashboard(Request $request)
    {
        new SEOData(
            title: "Dashboard",
            robots: [Robots::NONE]
        );

        return view('auth.dashboard');
    }

    public function login(Request $request)
    {
        new SEOData(
            title: "Login",
            robots: [Robots::NONE]
        );

        return view('auth.login');
    }

    public function forgotPassword(Request $request)
    {
        new SEOData(
            title: "Forgot password",
            robots: [Robots::NONE]
        );

        return view('auth.forgot-password');
    }
    
    public function resetPassword(Request $request)
    {
        new SEOData(
            title: "Reset password",
            robots: [Robots::NONE]
        );

        return view('auth.reset-password', ['request' => $request]);
    }
}
