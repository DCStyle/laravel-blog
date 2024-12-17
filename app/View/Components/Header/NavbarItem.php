<?php

namespace App\View\Components\Header;

use Illuminate\View\Component;

class NavbarItem extends Component
{
    public $item;
    public $mode;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($item, $mode)
    {
        $this->item = $item;
        $this->mode = $mode;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.header.navbar-item');
    }
}
