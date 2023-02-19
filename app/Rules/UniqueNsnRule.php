<?php

namespace App\Rules;

use Illuminate\Validation\Rules\Unique;
use Illuminate\Contracts\Validation\Rule;

class UniqueNsn implements Rule
{
    protected $ignore;

    public function __construct($ignore = null)
    {
        $this->ignore = $ignore;
    }

    public function passes($attribute, $value)
    {
        $query = Unique::table('students')
            ->where('nsn', $value);

        if ($this->ignore) {
            $query->whereNotIn('id', [$this->ignore]);
        }

        return $query->count() === 0;
    }

    public function message()
    {
        return 'The :attribute must be a unique NSN.';
    }
}
