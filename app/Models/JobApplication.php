<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    /**
     * stop the autoincrement
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
     * @var array<int, string>
     */
    protected $fillable = [
        'career_id',
        'linkedInUrl',
        'phoneNumber',
        'email',
        'firstName',
        'lastName',
        'coverLetter',
        'isPassed',
        'isClosed',
    ];

    /**
     * @return BelongsTo
     */
    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class);
    }

    /**
     * Get report.
     * @return MorphOne
     */
    public function media(): MorphOne
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
