<?php

namespace dominx99\school\Validation\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

class EmailAvaibleException extends ValidationException
{
    public static $defaultTemplates = [
        self::MODE_DEFAULT => [
            self::STANDARD => 'Email is already taken.'
        ]
    ];
}
