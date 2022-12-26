<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SEO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\SchemaOrg\Schema;
use Statamic\Facades\Entry;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $posts = Entry::query()->where('collection', 'posts')->get();
        } else {
            $posts = Entry::query()
                ->where('collection', 'posts')
                ->where('published', true)
                ->get();
        }

        SEO::make(
            title: 'Posts',
            noindex: (count($posts) === 0)
        );

        return view('posts.index', ['posts' => $posts]);
    }

    public function show(Request $request, string $slug)
    {
        $post = Entry::query()
            ->where('collection', 'posts')
            ->where('slug', $slug)
            ->first();

        if (is_null($post)) {
            return abort(404);
        }

        $author = $post->author;

        // Structured Data
        $schema = Schema::BlogPosting()
            ->headline($post->title)
            ->datePublished($post->date->isoFormat('YYYY-MM-DDThh:mm:ssZ'))
            ->author(Schema::person()->name($post->author->name))
            ->image([$post->featured_image ?? (env('APP_URL').'/og?url='.$request->path().'&title='.$post->title)]);

        // Opengraph and general metadata
        SEO::make(
            title: $post->title,
            description: $post->meta_description,
            thumbnail: $post->featured_image,
            noindex: false,
            type: [
                'type' => 'article',
                'items' => [
                    'author' => $post->author->name,
                    'published_time' => $post->date->isoFormat('YYYY-MM-DDThh:mm:ssZ'),
                ],
            ],
            schema: $schema->toScript()
        );

        return view('posts.show', ['post' => $post, 'author' => $author]);
    }
}
