<?php

namespace App\Support;

use App;
use Spatie\Csp\Directive;
use Spatie\Csp\Keyword;
use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Scheme;
use Spatie\Csp\Value;

class CSPPolicy extends Basic
{
    public function configure()
    {
        $this->addDirective(Directive::BASE, Keyword::SELF)
             ->addDirective(Directive::OBJECT, Keyword::NONE)
             ->addDirective(Directive::DEFAULT, [
                 Keyword::SELF,
                 Scheme::DATA,
                 Scheme::BLOB,
                 !App::environment('local') ? Value::NO_VALUE : 'http://localhost:5173',
             ])
             ->addDirective(Directive::SCRIPT, [
                 Keyword::UNSAFE_EVAL,
                 Keyword::STRICT_DYNAMIC,
             ])
             ->addDirective(Directive::CONNECT, [
                 Keyword::SELF,
                 'https://analytics.nilsbeerten.nl',
                 !App::environment('local') ? Value::NO_VALUE : 'http://localhost:5173',
                 !App::environment('local') ? Value::NO_VALUE : 'ws://localhost:5173',
             ])
             ->addDirective(Directive::STYLE, [
                 Keyword::SELF,
                 Keyword::UNSAFE_EVAL,
                 Scheme::DATA,
                 !App::environment('local') ? Value::NO_VALUE : 'http://localhost:5173',
             ])
             ->addDirective(Directive::STYLE_ATTR, [
                Keyword::UNSAFE_INLINE,
                Keyword::UNSAFE_EVAL
                ])
             ->addDirective(Directive::IMG, [
                 Keyword::SELF,
                 Scheme::DATA,
                 Scheme::BLOB,
                 Scheme::HTTPS,
                 !App::environment('local') ? Value::NO_VALUE : 'http://localhost:5173',
             ])
             ->addDirective(Directive::FONT, '*')
             ->addDirective(Directive::FRAME, [
                 Keyword::SELF,
                 'https://challenges.cloudflare.com'
             ]);

        $this->addNonceForDirective(Directive::STYLE);
        $this->addNonceForDirective(Directive::SCRIPT);
        
    }
}
