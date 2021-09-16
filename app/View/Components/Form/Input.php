<?php

namespace App\View\Components\Form;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Input extends Component
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
    public function __construct($name, $id,  $width = 'w-full',  $type = 'text',  $label = null, $value = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->width = $width;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;

        $this->loadSession();
    }

    /**
     * Carrega o valor do campo de acordo com o model passado no formulário
     */
    public function loadSession()
    {
        if (is_null($this->value) && Session::has('formModel')) {
            $model = Session::get('formModel');

            if ($model) {
                $this->value = $model->getAttribute($this->name);
            }
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.input');
    }
}
