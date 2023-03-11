<?php

namespace App\Http\Controllers;

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
            description: "Hai, I'm Nils. Coding projects I work on include the Refresh Leaderboard Openplanet plugin and the TMA sign generator tool.",
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
            description: 'A tool that enables Trackmania mappers to create signs with customizable text that fit in with the TMA signpack.'
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
