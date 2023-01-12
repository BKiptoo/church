<?php


namespace App\Traits;


use Exception;
use Webpatser\Uuid\Uuid;

trait Uuids
{
    /**
     * -----------------------------
     *  Setup model event hooks
     * -----------------------------
     * @throws Exception
     */
    public static function boot(): void
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string)Uuid::generate(4);
        });
    }
}
