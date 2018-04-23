<?php

namespace dominx99\school\Models;

use Illuminate\Database\Eloquent\Model;

class SocialProvider extends Model
{
    /**
     * @var string $table - the name of table in database
     */
    protected $table = 'social_providers';

    /**
     * @var array $fillable - list of fillable columns in database
     */
    protected $fillable = [
        'provider_id', 'provider' // WARNING: should i use user_id?
    ];

    /**
     * @return dominx99\Models\User
     * Method that returns instance of user depends on social provider
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
