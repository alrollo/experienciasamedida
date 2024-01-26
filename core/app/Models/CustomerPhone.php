<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class CustomerPhone extends Model
{
    use HasTranslations;

    protected $table = 'customers_phones';
    protected $appends = ['full_phone'];
    protected array $translatable = [];

    public function getFullPhoneAttribute()
    {
        return $this->prefix . ' ' . $this->phone;
    }

    /**
     * @return BelongsTo
     */
    public function customer() : BelongsTo
    {
        return $this->belongsTo(Customer::class);
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
}
