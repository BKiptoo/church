<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Country extends Model
{
    use HasFactory, HasSlug, Uuids, SoftDeletes;

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
        'name',
        'slug',
        'data'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * @return HasMany
     */
    public function coverages(): HasMany
    {
        return $this->hasMany(Coverage::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function ads(): HasMany
    {
        return $this->hasMany(Ad::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function careers(): HasMany
    {
        return $this->hasMany(Career::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function faqs(): HasMany
    {
        return $this->hasMany(Faq::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function offices(): HasMany
    {
        return $this->hasMany(Office::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function partners(): HasMany
    {
        return $this->hasMany(Partner::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function slides(): HasMany
    {
        return $this->hasMany(Slide::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function subScribers(): HasMany
    {
        return $this->hasMany(Subscriber::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function tenders(): HasMany
    {
        return $this->hasMany(Tender::class)->latest();
    }

    /**
     * @return HasMany
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class)->orderBy('name');
    }
}
