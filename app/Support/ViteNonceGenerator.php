<?php

namespace App\Support;

use Illuminate\Support\Facades\Vite;

class ViteNonceGenerator
{
    public function generate(): string
    {
        return Vite::useCspNonce();
    }
}
