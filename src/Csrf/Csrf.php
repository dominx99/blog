<?php

namespace dominx99\school\Csrf;

use Slim\Csrf\Guard;

class Csrf
{
    protected $guard;

    public function __construct($guard)
    {
        $this->guard = $guard;
    }

    public function getTokens()
    {
        return [
            $this->guard->getTokenNameKey() => $this->guard->getTokenName(),
            $this->guard->getTokenValueKey() => $this->guard->getTokenValue()
        ];
    }
}
