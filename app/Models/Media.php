<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    /**
     * Set the auto incrementing
     * pattern
     */
    public $incrementing = false;

    /**
     * type of auto-increment
     *
     * @string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mediaable_id',
        'mediaable_type',
        'pathNames',
        'pathUrls',
        'sizes',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'pathNames' => 'array',
        'pathUrls' => 'array',
        'sizes' => 'array'
    ];

    /**
     * Get the parent reportable model.
     * @return MorphTo
     */
    public function mediaable(): MorphTo
    {
        return $this->morphTo();
    }
}
