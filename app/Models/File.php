<?php

namespace App\Models;

use App\Repositories\Contracts\FileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'fileable_id',
        'fileable_type',
        'source',
        'name',
        'type',
        'size',
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getSizeAttribute($value)
    {
        /** @var FileRepositoryInterface $repository */
        $repository = app(FileRepositoryInterface::class);
        return $repository->formatBytes($value);
    }
}
