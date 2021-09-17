<?php

namespace App\View\Components\Form;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Form extends Component
{
    public $action;
    public $method;
    public $model;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($action, $method = 'post', $model = null)
    {
        $this->action = $action;
        $this->method = $method;

        $this->storageModel($model);
    }

    public function __destruct()
    {
        Session::forget('formModel');
    }

    public function storageModel(?Model $model)
    {
        if (!is_null($model)) {
            Session::flash('formModel', $model);
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.form.form');
    }
}
