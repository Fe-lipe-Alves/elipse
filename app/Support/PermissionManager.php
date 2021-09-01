<?php


namespace App\Support;


use App\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class PermissionManager
{
    /**
     * Obtém todas as permissões
     *
     * @return string[]
     */
    public static function all()
    {
        $reflectionClass = new ReflectionClass(get_called_class());
        return array_flip($reflectionClass->getConstants());
    }

    /**
     * Obtém a descrição ou o ID correspondente a permissão informada
     *
     * @param string|int $permission
     * @return false|int|string|null
     */
    public static function get($permission)
    {
        if (is_string($permission)) {
            return array_search($permission, self::all()) ?? null;
        }

        if (is_int($permission)) {
            return self::all()[$permission] ?? null;
        }

        return null;
    }

    /**
     * Obtém o model referente a permissão informada
     *
     * @param string|int $permission
     * @return Builder|Builder[]|Collection|Model|null
     */
    public static function model($permission)
    {
        if (is_string($permission)) {
            $permission = self::get($permission);
        }
        return Permission::query()->find($permission);
    }
}
