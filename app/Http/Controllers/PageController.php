<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SEOData;
use App\Classes\SEO\Robots;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;

class PageController extends Controller
{
    public function home(Request $request)
    {
        new SEOData(
            title: 'Home',
            description: "Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...",
            schema: Schema::organization()
                    ->url('https://nilsbeerten.nl/')
                    ->logo('https://nilsbeerten.nl/icon-512.png')
        );

        return view('home');
    }

    public function tmasigns(Request $request)
    {
        new SEOData(
            title: 'TMA Signs',
            description: 'A small web application to create signs with text defined by the user for Trackmania, styled to fit in with the TMA signpack.',
            robots: [Robots::NONE, Robots::NOIMAGEINDEX]
        );

        return view('tmasigns');
    }

    public function contact(Request $request)
    {
        new SEOData(
            title: 'Contact',
            description: 'Contact me',
        );

        return view('contact');
    }
}
