<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Skill extends Model
{

    use SoftDeletes;
    protected $dates = ['deleted_at'];


    protected $fillable = [
        'title',
        'creator_id'
    ];

    /**
     * @return BelongsToMany
     */
    public function exps()
    {
        return $this->belongsToMany(Exp::class, 'exp_skill');
    }

    /**
     * @return HasOne
     */
    public function creator()
    {
        return $this->hasOne(User::class, 'creator_id');
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_skill');
    }

}