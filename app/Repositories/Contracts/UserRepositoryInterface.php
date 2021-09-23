<?php


namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Valida e salva o registro no banco
     *
     * @param array $data
     * @param User|null $user
     * @return array
     */
    public function store(array $data, User $user = null): array;

    /**
     * Aplica validações nos valores recebidos
     *
     * @param array $input
     * @param User|null $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $input, User $user = null);

    /**
     * Gerar senha para usuário
     *
     * @param string $document
     * @param string $birth_date
     * @return string
     */
    public function newPassword(string $document, string $birth_date): string;


    /**
     * Obter lista de usuários ativo
     *
     * @param null $type_of_users
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUser($type_of_users = null);
}
