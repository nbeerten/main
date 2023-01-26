<?php

namespace App\Support;

use App;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Scheme;

class CSPPolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this->addDirective(Directive::SCRIPT, 'www.google.com')
             ->addDirective(Directive::DEFAULT, [
                 Keyword::SELF,
                 Scheme::DATA,
                 Scheme::BLOB,
                 'https://nilsbeerten.goatcounter.com/count',
                 ! App::environment('local') ?: 'http://localhost:5173',
             ])
             ->addDirective(Directive::SCRIPT, [
                 Keyword::SELF,
                 Keyword::UNSAFE_EVAL,
                 Keyword::UNSAFE_INLINE,
                 'https://challenges.cloudflare.com',
                 ! App::environment('local') ?: 'http://localhost:5173',
             ])
             ->addDirective(Directive::CONNECT, [
                 Keyword::SELF,
                 'https://nilsbeerten.goatcounter.com/',
                 'ws://localhost:5173',
             ])
             ->addDirective(Directive::STYLE, [
                 Keyword::SELF,
                 Keyword::UNSAFE_INLINE,
                 Scheme::DATA,
                 'http://localhost:5173',
             ])
             ->addDirective(Directive::STYLE_ATTR, Keyword::UNSAFE_INLINE)
             ->addDirective(Directive::IMG, [
                 Keyword::SELF,
                 Scheme::DATA,
                 Scheme::BLOB,
                 Scheme::HTTPS,
             ])
             ->addDirective(Directive::FONT, '*')
             ->addDirective(Directive::FRAME, [
                 Keyword::SELF,
                 'https://challenges.cloudflare.com',
                 'https://nilsbeerten.goatcounter.com/',
             ]);

        $this->addNonceForDirective(Directive::STYLE);
        $this->addNonceForDirective(Directive::SCRIPT);
    }
}
