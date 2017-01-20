<?php

use App\Models\Services\User\UserSkillService;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserSkillServiceTest extends TestCase
{

    /**
     * @var UserSkillService
     */
    protected $service;

    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();

        $this->service = \App::make(UserSkillService::class);
    }

    protected function createUser()
    {
        return factory(User::class)->create();
    }

//    protected function createAuthUser()
//    {
//        $user = $this->createUser();
//        $this->actingAs($user);
//        return $user;
//    }

    protected function createSkill()
    {
        return factory(Skill::class)->create();
    }

    /** @test */
    public function getUserSkill_gets_user_skills()
    {
        $user = $this->createUser();
        $skills = factory(Skill::class, 5)->create();

        $user->skills()->saveMany($skills);

        $gottenSkills = $this->service->getUserSkills($user->id);

        // todo: check if two arrays have the same contents regardless of order
        $this->assertEquals(count($skills), count($gottenSkills));
    }

    /** @test */
    public function addSkillToUser_adds_a_new_skill_to_a_user_and_returns_skill()
    {
        $skillData = ['title' => 'Linux'];
        $user = $this->createUser();

        $skill = $this->service->addSkillToUser($skillData, $user->id);

        $this->seeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);

        $this->assertEquals($skillData['title'], $skill->title);
    }

    /** @test */
    public function addSkillToUser_adds_an_existing_skill_to_a_user_that_does_not_have_that_skill()
    {
        $skill = $this->createSkill();
        $user = $this->createUser();

        $this->dontSeeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);

        $skill = $this->service->addSkillToUser($skill->toArray(), $user->id);

        $this->seeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function addSkillToUser_does_not_allow_duplicate_user_skills()
    {
        $skill = $this->createSkill();
        $user = $this->createUser();

        $user->skills()->attach($skill->id);

        $this->service->addSkillToUser($skill->toArray(), $user->id);

        self::assertEquals(count($user->skills()->get()), 1);
    }

    /** @test */
    public function removeSkillFromUser_removes_a_skill_from_a_user()
    {
        $skill = $this->createSkill();
        $user = $this->createUser();

        $user->skills()->attach($skill->id);

        $this->service->removeSkillFromUser($skill->id, $user->id);

        $this->dontSeeInDatabase('user_skill', [
            'skill_id' => $skill->id,
            'user_id' => $user->id
        ]);
    }

    /** @test */
    public function getUserSkill_gets_a_user_skill()
    {
        $user = $this->createUser();
        $skill = $this->createSkill();

        $user->skills()->attach($skill->id);

        $gottenSkill = $this->service->getUserSkill($user->id, $skill->id);

        $this->assertEquals($skill->id, $gottenSkill->id);
    }


}