<?php

namespace dominx99\school\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use dominx99\school\Models\User;

class EmailAvaible extends AbstractRule
{
    public function validate($input)
    {
        return !User::where('email', $input)->exists();
    }
}
