<?php

namespace dominx99\school\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method create(array $params)
 * @method firstOrCreate(array $params)
 */
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

    /**
     * @return dominx99\Models\User
     * Method that returns instance of SocialProvider depends on user
     * In addition: this is relation in database between those 2 models
     */
    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
}
