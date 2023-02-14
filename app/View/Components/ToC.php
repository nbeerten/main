<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class ToC extends Component
{
    public ?string $url;

    /**
     * Create a new component instance.
     */
    public function __construct($url = null)
    {
        $this->url = $url ?? '';
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.toc');
    }

    public function items(string $markdown): Collection
    {
        // Remove code blocks which might contain headers.
        $markdown = preg_replace('(```[a-z]*\n[\s\S]*?\n```)', '', $markdown);

        return collect(explode(PHP_EOL, $markdown))
            ->reject(function (string $line) {
                // Only search for level 2 and 3 headings.
                return ! Str::startsWith($line, '## ') && ! Str::startsWith($line, '### ');
            })
            ->map(function (string $line) {
                return [
                    'level' => strlen(trim(Str::before($line, '# '))) + 1,
                    'title' => $title = trim(Str::after($line, '# ')),
                    'anchor' => Str::slug($title),
                ];
            });
    }
}
