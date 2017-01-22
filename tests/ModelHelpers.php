<?php

namespace tests;

use App\Models\Exp;
use App\Models\Skill;
use App\Models\User;

trait ModelHelpers
{

    /**
     * @param string $class
     * @param bool $persist
     *
     * @return mixed
     */
    protected function create($class, $persist = false)
    {
        if ($persist) {
            return factory($class)->create();
        } else {
            return factory($class)->make();
        }
    }

    /**
     * @return User
     */
    protected function createUser($persist = false)
    {
        return $this->create(User::class, $persist);
    }

    /**
     * @return User
     */
    protected function createAuthUser()
    {
        $user = $this->persistUser();
        $this->actingAs($user);
        return $user;
    }

    /**
     * @param bool $persist
     * @return Exp
     */
    protected function createExp($persist = false)
    {
        return $this->create(Exp::class, $persist);
    }

    /**
     * @param bool $persist
     * @return Skill
     */
    protected function createSkill($persist = false)
    {
        return $this->create(Skill::class, $persist);
    }

    /**
     * @return User
     */
    protected function persistUser()
    {
        return $this->createUser(true);
    }

    /**
     * @return Exp
     */
    protected function persistExp()
    {
        return $this->createExp(true);
    }

    /**
     * @return mixed
     */
    protected function persistSkill()
    {
        return $this->createSkill(true);
    }

}