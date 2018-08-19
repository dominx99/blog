<?php

namespace dominx99\school\Validation\Rules;

use dominx99\school\Models\User;
use Respect\Validation\Rules\AbstractRule;

class EmailAvaible extends AbstractRule
{
    public function validate($input)
    {
        return !User::where('email', $input)->exists();
    }
}
