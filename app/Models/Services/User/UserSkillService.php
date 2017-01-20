<?php

namespace App\Models\Services\User;

use App\Models\Services\SkillService;
use App\Models\Services\UserService;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserSkillService
{

    /**
     * @var SkillService
     */
    protected $skillService;

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserSkillService constructor.
     * @param SkillService $skillService
     * @param UserService $userService
     */
    public function __construct(SkillService $skillService, UserService $userService)
    {
        $this->skillService = $skillService;
        $this->userService = $userService;
    }

    /**
     * @param $user_id
     * @return Collection
     */
    public function getUserSkills($user_id)
    {
        $user = $this->getUser($user_id);

        return $user->skills()->get();
    }

    /**
     * @param array $skillData
     * @param $user_id
     * @return Skill
     */
    public function addSkillToUser(array $skillData, $user_id)
    {
        /** @var Skill $skill */
        $skill = $this->skillService->resolveSkillByTitle($skillData, $user_id);

        if (!$this->getUserSkill($user_id, $skill->id)) {
            $skill->users()->attach($user_id);
        }

        return $skill;
    }

    /**
     * @param $skill_id
     * @param $user_id
     */
    public function removeSkillFromUser($skill_id, $user_id)
    {
        $user = $this->getUser($user_id);

        if($skill = $user->skills()->find($skill_id)) {
            $user->skills()->detach($skill_id);
            // todo: proper try catch and boolean return
        }
    }

    /**
     * @param $user_id
     * @param $skill_id
     * @return Skill
     */
    public function getUserSkill($user_id, $skill_id)
    {
        $user = $this->getUser($user_id);

        /** @var Skill $skill */
        $skill = $user->skills()->find($skill_id);

        return $skill;
    }

    /**
     * @param int $user_id
     * @return User
     */
    protected function getUser($user_id)
    {
        return $this->userService->getUserById($user_id);
    }

}