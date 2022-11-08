<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Classes\OpengraphImage\OpengraphImage;
use Exception;

class OpengraphImageController extends Controller
{
    public static function get(Request $request) : Response {

        $validator = Validator::make($request->all(), [
            'url' => ['required', 'string', 'max:256'],
            'title' => ['required', 'string', 'max:64']
        ]);
        if ($validator->fails()) return response(status: 404); // Returns plain 404 error instead of webpage
        $validated = $validator->validated();

        try {
        $opengraph = new OpengraphImage(url: $validated['url'] ?? $request->path(), title: $validated['title']);

        return response($opengraph->get())->header('Content-Type', 'image/png');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response(status: 404);
        }
    }
}
