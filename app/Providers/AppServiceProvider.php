<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LogViewer::auth(function ($request) {
            // return true to allow viewing the Log Viewer.
        });
    
        // Here's an example:
        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    config('log-viewer.allowed_email'),
                ]);
        });
    }
}
