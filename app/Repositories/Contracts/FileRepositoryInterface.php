<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

interface FileRepositoryInterface
{
    /**
     * Armazena o arquivo e salva seu registro no banco de dados relacionando ao modelo recebido
     *
     * @param Model $model
     * @param UploadedFile[]|UploadedFile $file
     * @return array
     */
    public function save(Model $model, $file): array;

    /**
     * Converte o valor em bytes para a grandeza equivalente
     *
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public function formatBytes($bytes, int $precision = 2): string;

    /**
     * Deleta um ou mais arquivos
     *
     * @param $files
     */
    public function deletedById($files);
}
