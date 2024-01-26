<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Option extends Model
{
    use HasTranslations;

    protected $table = 'masters_options';

    protected $translatable = ['option', 'option_slug'];

    /**
     * @return BelongsTo
     */
    public function master() : BelongsTo
    {
        return $this->belongsTo('App\Models\Master', 'id');
    }
}
