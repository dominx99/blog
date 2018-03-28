<?php

namespace dominx99\school\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var string $table Name of table in database
     */
    protected $table = 'users';

    /**
     * @var array $fillable List of columns that are editable in database
     */
    protected $fillable = [
        'email',
        'name',
        'password'
    ];
}
