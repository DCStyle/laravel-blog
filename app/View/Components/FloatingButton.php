<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FloatingButton extends Component
{
    public $icon;
    public $url;
    public $tooltip;

    public function __construct($icon = 'fa-plus', $url = '#', $tooltip = 'Click me')
    {
        $this->icon = $icon;
        $this->url = $url;
        $this->tooltip = $tooltip;
    }

    public function render()
    {
        return view('components.floating-button');
    }
}
