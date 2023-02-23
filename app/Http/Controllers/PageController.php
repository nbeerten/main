<?php

namespace App\Http\Controllers;

use App\Classes\SEO\Robots;
use App\Classes\SEO\SEO;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\SchemaOrg\Schema;

class PageController extends Controller
{
    public function home(Request $request): View
    {
        SEO::share(
            title: 'Home',
            description: "Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...",
            schema: Schema::organization()
                    ->url('https://nilsbeerten.nl/')
                    ->logo('https://nilsbeerten.nl/icon-512.png')
        );

        return view('home');
    }

    public function tmasigns(Request $request): View
    {
        SEO::share(
            title: 'TMA Signs',
            description: 'A small web application to create signs with text defined by the user for Trackmania, styled to fit in with the TMA signpack.',
            robots: [Robots::NONE, Robots::NOIMAGEINDEX]
        );

        return view('tmasigns');
    }

    public function contact(Request $request): View
    {
        SEO::share(
            title: 'Contact',
            description: 'Contact me',
        );

        return view('contact');
    }
}
