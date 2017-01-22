<?php

namespace App\Models\Policies;

use App\Models\User;

trait AdminOverrideTrait
{

    public function before(User $user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }

}