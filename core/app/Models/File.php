<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Translatable\HasTranslations;

class File extends Model
{
    use HasTranslations;

    protected array $translatable = ['name', 'description'];

    /**
     * @return MorphTo
     */
    public function attachable() : MorphTo
    {
        return $this->morphTo();
    }
}
