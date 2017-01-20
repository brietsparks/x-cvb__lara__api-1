<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Timespan extends Model
{
    protected $table = 'timespans';

    /**
     * @return BelongsToMany
     */
    public function exps()
    {
        return $this->belongsToMany(Exp::class, 'exp_timespan');
    }

}