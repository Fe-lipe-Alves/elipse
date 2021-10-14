<?php

namespace App\Repositories;

use App\Models\File;
use App\Repositories\Contracts\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileRepository implements FileRepositoryInterface
{
    /**
     * Armazena o arquivo e salva seu registro no banco de dados relacionando ao modelo recebido
     *
     * @param Model $model
     * @param UploadedFile[]|UploadedFile $file
     * @return array
     */
    public function save(Model $model, $file): array
    {
        $filesProcessed = [];

        if (is_array($file)) {
            foreach ($file as $fileItem) {
                $return = $this->save($model, $fileItem);

                if ($return['success']) {
                    $filesProcessed = $return['files'];
                } else {
                    return $return;
                }
            }

            return [
                'success' => true,
                'files' => $filesProcessed,
            ];
        } elseif ($file instanceof UploadedFile) {
            $source = $file->store('public/files');
            if (!$source) {
                return [
                    'success' => false,
                    'message' => 'Falha ao salvar arquivo '. $file->getClientOriginalName(),
                ];
            }

            $fileModel = new File([
                'fileable_id' => $model->getAttribute('id'),
                'fileable_type' => $model->getMorphClass(),
                'name' => $file->getClientOriginalName(),
                'type' => $file->getClientOriginalExtension(),
                'source' => $source,
                'size' => $file->getSize(),
            ]);

            $saved = $fileModel->save();
            if (!$saved) {
                return [
                    'success' => false,
                    'message' => 'Falha ao salvar arquivo '. $file->getClientOriginalName(),
                ];
            }

            return [
                'success' => true,
                'files' => $fileModel,
            ];
        }

        return [
            'success' => false
        ];
    }

    /**
     * Converte o valor em bytes para a grandeza equivalente
     *
     * @param $bytes
     * @param int $precision
     * @return string
     */
    public function formatBytes($bytes, int $precision = 2): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Deleta um ou mais arquivos
     *
     * @param $files
     */
    public function deletedById($files)
    {
        if (!is_array($files)) {
            $files = [$files];
        }

        $files = File::query()->whereIn('id', $files)->get();

        foreach ($files as $file) {
            Storage::delete($file->source);
            $file->delete();
        }
    }
}
