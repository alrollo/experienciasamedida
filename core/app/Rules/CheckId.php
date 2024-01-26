<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckId implements Rule
{
    protected $id = null;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return decrypt($value) == $this->id;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Los identificadores no coinciden.';
    }
}
