<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exp extends Model
{
    protected $table = 'exps';

    protected $fillable = [
        'user_id',
        'parent_id',
        'next_id',
        'type',
        'title',
        'subtitle',
        'summary',
    ];

    /**
     * @return BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Exp::class, 'parent_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Exp::class, 'parent_id')->with(['children', 'skills']);
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    /**
     * @return BelongsToMany
     */
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'exp_skill');
    }

    /**
     * @return BelongsToMany
     */
    public function timespans()
    {
        return $this->belongsToMany(Timespan::class, 'exp_timespan');
    }


}