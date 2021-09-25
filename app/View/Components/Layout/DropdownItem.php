<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class DropdownItem extends Component
{
    public $label;
    public $href;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label, $href = '')
    {
        $this->label = $label;
        $this->href = $href;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.drop-down-item');
    }
}
