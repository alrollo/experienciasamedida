<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Translatable\HasTranslations;

class Promotion extends Model
{
    use HasTranslations;

    protected array $translatable = ['title', 'title_slug', 'summary', 'description'];

    /**
     * @return BelongsTo
     */
    public function type() : BelongsTo
    {
        return $this->belongsTo('App\Models\Option', 'type_id');
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

    /**
     * Relacionamos con las imágenes
     * @return MorphMany
     */
    public function images()
    {
        return $this->morphMany('App\Models\File', 'attachable')->where('type', '=', 'image')->orderBy('order', 'asc');
    }

    /**
     * Relacionamos con las imágenes
     * @return MorphMany
     */
    public function files()
    {
        return $this->morphMany('App\Models\File', 'attachable')->where('type', '=', 'doc')->orderBy('order', 'asc');
    }
}
