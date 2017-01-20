<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'email', 'password', 'api_token'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @return HasMany
     */
    public function exps()
    {
        return $this->hasMany(Exp::class);
    }

    /**
     * @return BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    /**
     * @return HasOne
     */
    public function person()
    {
        return $this->hasOne(Person::class);
    }
}
