<?php


namespace App\Support\Traits;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait HasModel
{
    /**
     * Armazena o objeto model
     *
     * @var Model|mixed
     */
    private $model;

    /**
     * Cria uma nova instância de repositório. Pode receber o model como parâmetro
     *
     * ModelTrait constructor.
     * @param Model|null $model
     */
    public function __construct(Model $model = null)
    {
        $this->model = $model ?? new $this->modelClass();
    }

    /**
     * Obtém ou altera o model presente na instância do repositório
     *
     * @param Model|null $model
     * @return $this|Model|null
     * @throws Exception
     */
    public function model(Model $model = null)
    {
        if ($model) {
            if ($model instanceof $this->modelClass) {
                $this->model = $model;
                return $this;
            }
            throw new Exception("O objeto model fornecido não é um objeto da classe ".$this->modelClass.'.');
        } else {
            return $model;
        }
    }

    /**
     * Identifica se há um valor de id presente na requisição e o busca na tabela do model referente ao repositório
     *
     * @param array|null $data
     * @param string $name
     * @return mixed
     */
    public function identifyModel(array $data = null, $name = 'id')
    {
        if (!$data) {
            $data = request()->all();
        }

        if (Arr::exists($data, $name)){
            $model = $this->modelClass::query()->find($data[$name]);
        }

        $this->model = $model ?? new $this->modelClass();
        return new $this->model;
    }
}
