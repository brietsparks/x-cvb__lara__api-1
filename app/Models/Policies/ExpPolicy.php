<?php

namespace App\Models\Policies;

use App\Models\Exp;
use App\Models\User;

class ExpPolicy extends ModelPolicy
{

    public function update(User $user, Exp $exp)
    {
        return $user->id === $exp->user_id;
    }

    public function destroy(User $user, Exp $exp)
    {
        return $user->id === $exp->user_id;
    }



}