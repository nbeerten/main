<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Facades\Entry;
use Spatie\SchemaOrg\Schema;
use App\Classes\SEO\SEO;

class HomeController extends Controller
{
    public function show(Request $request)
    {
        $posts = Entry::query()
            ->where('collection', 'posts')
            ->take(6)
            ->get();

        $schema = Schema::organization()
            ->url('https://nilsbeerten.nl/')
            ->logo('https://nilsbeerten.nl/icon-512.png');

        SEO::make(
            title: "Home",
            description: "Hai, I'm Nils. Projects include Refresh Leaderboard: a plugin for Openplanet and the rewrite of nilsbeerten.nl...",
            noindex: false,
            schema: $schema->toScript()
        );


        return view('home', ['posts' => $posts]);
    }
}
