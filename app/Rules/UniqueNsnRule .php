<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class UniqueNsnRule implements Rule
{
    protected $ignoreId;

    public function __construct($ignoreId = null)
    {
        $this->ignoreId = $ignoreId;
    }

    public function passes($attribute, $value)
    {
        $unique = Unique::make('students', 'nsn')->where($attribute, $value);

        if ($this->ignoreId !== null) {
            $unique->ignore($this->ignoreId, 'id');
        }

        return $unique->count() === 0;
    }

    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
