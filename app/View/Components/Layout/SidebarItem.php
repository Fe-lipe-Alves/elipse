<?php

namespace App\View\Components\Layout;

use Illuminate\View\Component;

class SidebarItem extends Component
{
    public $name;
    public $href;
    public $icon;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $href, $icon)
    {
        $this->name = $name;
        $this->href = $href;
        $this->icon = $icon;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.components.sidebar-item');
    }
}
