<?php


namespace App\Support;


use App\Models\Log;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Logger
{
    /**
     * Rótulos dos logs
     */
    private const CREATED = 'created';
    private const UPDATED = 'updated';
    private const DELETED = 'deleted';
    private const SAVED = 'saved';

    /**
     * Cria um log no banco de dados salvando as mudanças presentes no model e o usuário responsável
     *
     */
    public static function register(Model $model, string $action)
    {
        $log = new Log();
        $log->action = $action;
        $log->user_id = $user ?? Auth::id();
        $log->model_type = get_class($model);
        $log->model_id = $model->id;

        $log->before = self::getBefore($model);
        $log->after = $model->getDirty();

        self::dispatch($log);
    }

    /**
     * Obtem os dados modificados para salvar no log
     *
     * @param Model $model
     * @return array
     */
    public static function getBefore(Model $model): array
    {
        $before = [];
        foreach ($model->getDirty() as $key => $value) {
            $value = $model->getOriginal($key);

            if ($value instanceof Carbon) {
                $value = $value->format('Y-m-d H:i:s');
            }
            $before[$key] = $value;
        }
        return $before;
    }

    /**
     * Armazena o log no banco de dados
     *
     * @param Log $log
     */
    public static function dispatch(Log $log)
    {
        $log->created_at = $log->freshTimestamp();
        $log->save();
    }

    /**
     * Cria um log para a ação Criar
     *
     * @param Model $model
     */
    public static function created(Model $model)
    {
        self::register($model, self::CREATED);
    }

    /**
     * Cria um log para a ação Atualizar
     *
     * @param Model $model
     */
    public static function updated(Model $model)
    {
        self::register($model, self::UPDATED);
    }

    /**
     * Cria um log para a ação Deletar
     *
     * @param Model $model
     */
    public static function deleted(Model $model)
    {
        self::register($model, self::DELETED);
    }

    /**
     * Cria um log para a ação Salvar
     *
     * @param Model $model
     */
    public static function saved(Model $model)
    {
        self::register($model, self::SAVED);
    }
}
