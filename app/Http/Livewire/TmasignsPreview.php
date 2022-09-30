<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Classes\TMASigns\TMASigns;

class TmasignsPreview extends Component
{
    public string $format;
    public int $size = 2;
    public string $text = "Preview";
    public string $subtext = "";

    public function render()
    {
        return view('livewire.tmasigns-preview', ['preview' => "/tmasigns/jpg/{$this->size}/{$this->text}/{$this->subtext}"]);
    }
}
