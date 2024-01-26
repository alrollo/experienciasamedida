<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seo extends Model
{
    protected $table = 'seo';

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
