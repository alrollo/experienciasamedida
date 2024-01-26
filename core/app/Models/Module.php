<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class Module extends Model
{
    use HasTranslations;

    protected $table = 'pages_modules';
    protected $translatable = ['content'];

    /**
     * @return BelongsTo
     */
    public function page() : BelongsTo
    {
        return $this->belongsTo('App\Models\Page', 'id');
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
