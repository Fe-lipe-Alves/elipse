<?php

namespace App\View\Components\Layout;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Dropdown extends Component
{
    public $ref;
    public $order;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($ref)
    {
        $this->ref = $ref;

        $this->getOrder();
    }

    public function getOrder()
    {
        if (!request()->session()->has('order_dropdown')) {
            request()->session()->now('order_dropdown', 0);
        }

        request()->session()->increment('order_dropdown');
        $this->order = request()->session()->get('order_dropdown');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.layout.dropdown');
    }
}
