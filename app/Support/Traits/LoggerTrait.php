<?php


namespace App\Support\Traits;


use App\Models\Log;
use App\Support\Logger;

trait LoggerTrait
{
    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            Logger::created($model);
        });

        static::updated(function ($model) {
            Logger::updated($model);
        });

        static::deleted(function ($model) {
            Logger::deleted($model);
        });
    }

    /**
     *
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function logs()
    {
        return $this->morphMany(Log::class, 'model');
    }
}
