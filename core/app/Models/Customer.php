<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Customer extends Model
{
    use HasTranslations;

    protected array $translatable = [];
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->surname;
    }

    /**
     * @return HasMany
     */
    public function phones() : HasMany
    {
        return $this->hasMany(CustomerPhone::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(MasterOption::class, 'customers_tags', 'customer_id', 'option_id');
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updater() : BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relacionamos con las imágenes
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany(File::class, 'attachable')
            ->where('type', '=', 'image')
            ->orderBy('order', 'asc');
    }

    /**
     * Relacionamos con las imágenes
     * @return MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'attachable')
            ->where('type', '=', 'doc')
            ->orderBy('order', 'asc');
    }
}
