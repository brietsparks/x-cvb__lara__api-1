<?php

namespace tests;

use App\Models\Exp;
use App\Models\Skill;
use App\Models\User;

trait ModelHelpers
{

    /**
     * @return User
     */
    protected function createUser()
    {
        return factory(User::class)->create();
    }

    /**
     * @return User
     */
    protected function createAuthUser()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        return $user;
    }

    /**
     * @return Exp
     */
    protected function createExp()
    {
        return factory(Exp::class)->create();
    }

    /**
     * @return Skill
     */
    protected function createSkill()
    {
        return factory(Skill::class)->create();
    }

}