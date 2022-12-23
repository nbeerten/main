<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\SchemaOrg\Schema;
use Statamic\Facades\Entry;
use Statamic\Statamic;

class PageController extends Controller
{
    public function home(Request $request)
    {
        if (Auth::check()) {
            $posts = Entry::query()
            ->where('collection', 'posts')
            ->take(6)
            ->get();
        } else {
            $posts = Entry::query()
            ->where('collection', 'posts')
            ->where('published', true)
            ->take(6)
            ->get();
        }

        $schema = Schema::organization()
            ->url('https://nilsbeerten.nl/')
            ->logo('https://nilsbeerten.nl/icon-512.png');

        SEO::make(
            title: 'Home',
            description: "Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...",
            noindex: false,
            schema: $schema->toScript()
        );

        return view('home', ['posts' => $posts]);
    }

    public function contact(Request $request)
    {
        SEO::make(
            title: 'Contact',
            description: 'Contact me',
            noindex: false
        );

        $form = Statamic::tag('form:contact');

        return view('contact', ['form' => $form]);
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
