<?php


namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Validar e cadastrar novo usuário
     *
     * @param array $input
     * @return null
     */
    public function create(array $input);

    /**
     * Validar e salvar usuário
     *
     * @param User $user
     * @param array $input
     * @return User|\Illuminate\Support\MessageBag
     */
    public function update(User $user, array $input);

    /**
     * Gerar senha para usuário
     *
     * @param array $data
     * @return string
     */
    public function newPassword(array $data): string;


    /**
     * Obter lista de usuários ativo
     *
     * @param null $type_of_users
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUser($type_of_users = null);
}
