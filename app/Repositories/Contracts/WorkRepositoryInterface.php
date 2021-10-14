<?php

namespace App\Repositories\Contracts;

use App\Models\Work;

interface WorkRepositoryInterface
{
    /**
     * Obtém todos os trabalhos registrados
     *
     * @return Work[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getWorks();

    /**
     * Cria ou atualiza um registro de trabalho
     *
     * @param array $data
     * @param Work|null $work
     * @return array
     */
    public function store(array $data, Work $work = null): array;

    /**
     * Aplica regras de validação nos campos do formulário
     *
     * @param array $data
     * @param Work|null $work
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $data, Work $work = null);
}
