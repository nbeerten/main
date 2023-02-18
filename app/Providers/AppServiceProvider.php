<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
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
