<?php


namespace App\Support;


class Permissions extends PermissionManager
{
    /*
    |--------------------------------------------------------------------------
    | Permissões
    |--------------------------------------------------------------------------
    |
    | Criar as constantes com o nome da permissão e com o valor do id dela.
    | Constantes devem ser públicas para que sejam acessíveis em qualquer
    | classe do projeto.
    |
    |
    | Ao inserir uma nova permissõ é necessário rodar novamente as seeds,
    | para que a mesma seja inserida no banco de dados. Leve sempre em
    | consideração os ids em ordem sequenciais.
    |
    */

    public const ADMIN = 1;
}
