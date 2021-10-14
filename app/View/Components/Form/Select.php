<?php

namespace App\View\Components\Form;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $options;
    public $selected;
    public $width;
    public $value;
    public $description;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        $name,
        $label = null,
        $options = [],
        $selected = null,
        $width = 'w-full',
        $value = 'id',
        $description = 'description'
    )
    {
        $this->name = $name;
        $this->label = $label;
        $this->selected = $selected;
        $this->width = $width;
        $this->value = $value;
        $this->description = $description;

        $this->loadOptions($options, $value, $description);
        $this->loadSession();
    }

    /**
     * Preenche o vetor de opções de acordo com o vetor recebido, permitindo modelos ou apenas vetores
     *
     * @param array|Collection $options
     * @param string $value
     * @param string $description
     */
    public function loadOptions($options, $value, $description)
    {
        $opts = [];
        if (!empty($options)) {

            foreach ($options as $key => $option) {
                $opt = new \stdClass();

                if ($option instanceof Model) {
                    $opt->value = $option->getAttribute($value);
                    $opt->description = $option->getAttribute($description);
                } else {
                    $opt->value = is_string($key) ? $key : $option[$value];
                    $opt->description = $option[$description];
                }

                $opts[] = $opt;
            }
        }

        $this->options = $opts;
    }

    /**
     * Carrega o valor do campo de acordo com o model passado no formulário
     */
    public function loadSession()
    {
        if (is_null($this->selected) && Session::has('formModel')) {
            $model = Session::get('formModel');

            if ($model) {
                $this->selected = $model->getAttribute($this->name);
            }
        }
    }

    public function isSelected($value)
    {
        return $value == $this->selected;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('components.form.select');
    }
}
