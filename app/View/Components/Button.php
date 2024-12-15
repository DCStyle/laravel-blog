<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $type;
    public $href;
    public $action;
    public $color;
    public $size;
    public $onClick;

    /**
     * Create a new component instance.
     *
     * @param string|null $type
     * @param string|null $href
     * @param string|null $action
     * @param string|null $color
     * @param string|null $size
     * @param string|null $onClick
     */
    public function __construct($type = 'button', $href = null, $action = null, $color = 'blue', $size = 'md', $onClick = null)
    {
        $this->type = $type;
        $this->href = $href;
        $this->action = $action;
        $this->color = $color;
        $this->size = $size;
        $this->onClick = $onClick;

        if ($this->type === 'delete') {
            $this->color = 'red';
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
