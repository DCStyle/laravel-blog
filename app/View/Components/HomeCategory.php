<?php

namespace App\View\Components;

use Illuminate\View\Component;

class HomeCategory extends Component
{
    public $title;
    public $settings;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $settings)
    {
        $this->title = $title;
        $this->settings = $settings;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.home-category');
    }
}
