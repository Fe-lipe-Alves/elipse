<?php

namespace App\View\Components\Form;

use Illuminate\View\Component;

class InputRadio extends Component
{
    public $name;
    public $id;
    public $width;
    public $type;
    public $label;
    public $value;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $id, $label, $value, $width = 'w-full',  $type = 'radio')
    {
        $this->name = $name;
        $this->id = $id;
        $this->width = $width;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input-radio');
    }
}
