<?php

namespace tests\Models\Services;

use App\Models\Skill;
use App\Models\User;
use App\Models\Services\SkillService;


class SkillServiceTest extends ServiceTestCase
{

    /**
     * @var SkillService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new SkillService();
    }

    protected function makeSkillData()
    {
        $skillData = [
            'title' => 'Linux'
        ];

        return $skillData;
    }


    /** @test */
    public function createSkill_creates_a_skill()
    {
        // context
        $skillData = $this->makeSkillData();
        $user = factory(User::class)->create();

        // action
        $this->service->createSkill($skillData, $user->id);

        // assert
        $this->seeInDatabase('skills', $skillData);
    }

    /** @test */
    public function createSkill_returns_the_created_skill()
    {
        // context
        $skillData = $this->makeSkillData();
        $user = factory(User::class)->create();

        // action
        $skill = $this->service->createSkill($skillData, $user->id);

        // assert
        $this->assertTrue($skill instanceof Skill);
        $this->assertEquals($skill->title, $skillData['title']);
        $this->assertEquals($skill->creator_id, $user->id);
        $this->assertNotNull($skill->id);
    }

    /** @test */
    public function resolveSkill_returns_an_existing_skill_given_its_title()
    {
        // context
        $createdSkill = factory(Skill::class)->create();
        $user = factory(User::class)->create();

        // action
        $resolvedSkill = $this->service->resolveSkillByTitle($createdSkill->toArray(), $user->id);

        // assert
        $this->assertEquals($createdSkill->toArray(), $resolvedSkill->toArray());
    }

    /** @test */
    public function resolveSkill_creates_and_returns_a_new_skill_if_no_skills_have_the_given_title()
    {
        // context
        $skillData = $this->makeSkillData();
        $user = factory(User::class)->create();

        // action
        $resolvedSkill = $this->service->resolveSkillByTitle($skillData, $user->id);

        // assert
        $this->assertTrue($resolvedSkill instanceof Skill);
        $this->assertEquals($resolvedSkill->title, $skillData['title']);
    }

    /** @test */
    public function getSkillById_gets_a_skill_by_id()
    {
        // context
        $createdSkill = factory(Skill::class)->create();

        // action
        $gottenSkill = $this->service->getSkillById($createdSkill->id);

        // assert
        $this->assertEquals($createdSkill->toArray(), $gottenSkill->toArray());
    }

    /** @test */
    public function getSkillByTitle_gets_a_skill_by_title()
    {
        // context
        $createdSkill = factory(Skill::class)->create();

        // action
        $gottenSkill = $this->service->getSkillByTitle($createdSkill->title);

        // assert
        $this->assertEquals($createdSkill->toArray(), $gottenSkill->toArray());
    }

    /** @test */
    public function updateSkill_updates_a_skill()
    {
        //context
        $createdSkill = factory(Skill::class)->create();

        // action
        $this->service->updateSkill($createdSkill->id, ['title' => 'FoobarLinux']);

        // assert
        $this->seeInDatabase('skills', [
            'title' => 'FoobarLinux'
        ]);
    }

//    /** @test */
//    public function updateSkill_returns_the_updated_skill()
//    {
//        $createdSkill = $this->createSkill();
//
//        $updatedSkill = $this->service->updateSkill($createdSkill->id, ['title' => 'FoobarLinux']);
//
//        $this->assertEquals($createdSkill->id, $updatedSkill->id);
//        $this->assertEquals($updatedSkill->title, 'FoobarLinux');
//    }
//
//    /** @test */
//    public function deleteSkill_deletes_a_skill()
//    {
//        $createdSkill = $this->createSkill();
//
//        $this->seeInDatabase('skills', [
//            'id' => $createdSkill->id
//        ]);
//
//        $this->service->deleteSkill($createdSkill->id);
//
//        $this->dontSeeInDatabase('skills', [
//            'id' => $createdSkill->id
//        ]);
//    }

}