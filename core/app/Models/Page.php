<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasTranslations;

    protected $translatable = [];
    protected $casts = [
        'url' => 'array',
    ];

    /**
     * @return HasMany
     */
    public function modules() : HasMany
    {
        return $this->hasMany('App\Models\Module', 'page_id')->orderBy('order');
    }

    /**
     * @return BelongsTo
     */
    public function creator() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'created_by');
    }

    /**
     * @return BelongsTo
     */
    public function updater() : BelongsTo
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }
}
