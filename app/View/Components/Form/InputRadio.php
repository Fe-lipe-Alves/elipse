<?php

namespace App\View\Components\Form;

use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class InputRadio extends Component
{
    public $name;
    public $id;
    public $width;
    public $type;
    public $label;
    public $value;
    public $checked;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($name, $id, $label, $value, $width = 'w-full',  $type = 'radio', $checked = false)
    {
        $this->name = $name;
        $this->id = $id;
        $this->width = $width;
        $this->type = $type;
        $this->label = $label;
        $this->value = $value;
        $this->checked = $checked;

        $this->loadSession();
    }

    /**
     * Carrega o valor do campo de acordo com o model passado no formulário
     */
    public function loadSession()
    {
        if (!$this->checked && Session::has('formModel')) {
            $model = Session::get('formModel');

            if ($model) {
                $this->checked = $model->getAttribute($this->name) == $this->value;
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
        return view('components.form.input-radio');
    }
}
