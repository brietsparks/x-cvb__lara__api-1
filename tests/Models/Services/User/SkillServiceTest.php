<?php

namespace tests\Models\Services\User;

use App\Models\Services\User\UserSkillService;
use App\Models\Skill;
use App\Models\User;
use tests\Models\Services\ServiceTestCase;

class SkillServiceTest extends ServiceTestCase
{

    /**
     * @var UserSkillService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = \App::make(UserSkillService::class);
    }

    /** @test */
    public function getUserSkill_gets_user_skills()
    {
        // context
        $user = factory(User::class)->create();
        $skills = factory(Skill::class, 5)->create();
        $user->skills()->saveMany($skills);

        // action
        $gottenSkills = $this->service->getUserSkills($user->id);

        // assert
        // todo: check if two arrays have the same contents regardless of order
        $this->assertEquals(count($skills), count($gottenSkills));
    }

    /** @test */
    public function addSkillToUser_adds_a_new_skill_to_a_user_and_returns_skill()
    {
        // context
        $skillData = ['title' => 'Linux'];
        $user = factory(User::class)->create();

        // action
        $skill = $this->service->addSkillToUser($skillData, $user->id);

        // assert
        $this->seeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);

        $this->assertEquals($skillData['title'], $skill->title);
    }

    /** @test */
    public function addSkillToUser_adds_an_existing_skill_to_a_user_that_does_not_have_that_skill()
    {
        // context
        $skill = factory(Skill::class)->create();
        $user = factory(User::class)->create();

        // sanity
        $this->dontSeeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);

        // action
        $skill = $this->service->addSkillToUser($skill->toArray(), $user->id);

        // assert
        $this->seeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function addSkillToUser_does_not_allow_duplicate_user_skills()
    {
        // context
        $skill = factory(Skill::class)->create();
        $user = factory(User::class)->create();
        $user->skills()->attach($skill->id);

        // action
        $this->service->addSkillToUser($skill->toArray(), $user->id);

        // assert
        $this->assertEquals(count($user->skills()->get()), 1);
    }

    /** @test */
    public function removeSkillFromUser_removes_a_skill_from_a_user()
    {
        //context
        $skill = factory(Skill::class)->create();
        $user = factory(User::class)->create();
        $user->skills()->attach($skill->id);

        // action
        $this->service->removeSkillFromUser($skill->id, $user->id);

        // assert
        $this->dontSeeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function getUserSkill_gets_a_user_skill()
    {
        // context
        $skill = factory(Skill::class)->create();
        $user = factory(User::class)->create();
        $user->skills()->attach($skill->id);

        // action
        $gottenSkill = $this->service->getUserSkill($user->id, $skill->id);

        // assert
        $this->assertEquals($skill->id, $gottenSkill->id);
    }


}