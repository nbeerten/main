<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SEO;
use Illuminate\Http\Request;
use Spatie\SchemaOrg\Schema;

class PageController extends Controller
{
    public function home(Request $request)
    {
        $schema = Schema::organization()
            ->url('https://nilsbeerten.nl/')
            ->logo('https://nilsbeerten.nl/icon-512.png');

        SEO::make(
            title: 'Home',
            description: "Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...",
            noindex: false,
            schema: $schema->toScript()
        );

        return view('home');
    }

    public function contact(Request $request)
    {
        SEO::make(
            title: 'Contact',
            description: 'Contact me',
            noindex: false
        );

        return view('contact');
    }

    public function tmasigns(Request $request)
    {
        SEO::make(
            title: 'TMA Signs',
            description: 'A small web application to create signs with text defined by the user for Trackmania, styled to fit in with the TMA signpack.',
            noindex: true
        );

        return view('tmasigns');
    }
}
