<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductQuantity implements Rule
{
    private $manage_stock;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($manage_stock)
    {
        $this->manage_stock = $manage_stock;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value = // qty
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->manage_stock == 1 && $value == null) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
