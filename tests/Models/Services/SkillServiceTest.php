<?php

use App\Models\Skill;
use App\Models\User;
use App\Models\Services\SkillService;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SkillServiceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var SkillService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new SkillService();
    }

    protected function createUser()
    {
        return factory(User::class)->create();
    }

    protected function createAuthUser()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        return $user;
    }

    protected function createSkill()
    {
        return factory(Skill::class)->create();
    }

    protected function getSkillData()
    {
        $skillData = [
            'title' => 'Linux'
        ];

        return $skillData;
    }


    /** @test */
    public function createSkill_creates_a_skill()
    {
        $skillData = $this->getSkillData();
        $user = $this->createUser();

        $this->service->createSkill($skillData, $user->id);

        $this->seeInDatabase('skills', $skillData);
    }

    /** @test */
    public function createSkill_returns_the_created_skill()
    {
        $skillData = $this->getSkillData();
        $user = $this->createUser();

        $skill = $this->service->createSkill($skillData, $user->id);

        $this->assertTrue($skill instanceof Skill);
        $this->assertEquals($skill->title, $skillData['title']);
        $this->assertEquals($skill->creator_id, $user->id);
        $this->assertNotNull($skill->id);
    }

    /** @test */
    public function resolveSkill_returns_an_existing_skill_given_its_title()
    {
        $createdSkill = $this->createSkill();
        $user = $this->createUser();

        $resolvedSkill = $this->service->resolveSkillByTitle($createdSkill->toArray(), $user->id);

        $this->assertEquals($createdSkill->toArray(), $resolvedSkill->toArray());
    }

    /** @test */
    public function resolveSkill_creates_and_returns_a_new_skill_if_no_skills_have_the_given_title()
    {
        $skillData = $this->getSkillData();
        $user = $this->createUser();

        $resolvedSkill = $this->service->resolveSkillByTitle($skillData, $user->id);

        $this->assertTrue($resolvedSkill instanceof Skill);
        $this->assertEquals($resolvedSkill->title, $skillData['title']);
    }

    /** @test */
    public function getSkillById_gets_a_skill_by_id()
    {
        $createdSkill = $this->createSkill();

        $gottenSkill = $this->service->getSkillById($createdSkill->id);

        $this->assertEquals($createdSkill->toArray(), $gottenSkill->toArray());
    }

    /** @test */
    public function getSkillByTitle_gets_a_skill_by_title()
    {
        $createdSkill = $this->createSkill();

        $gottenSkill = $this->service->getSkillByTitle($createdSkill->title);

        $this->assertEquals($createdSkill->toArray(), $gottenSkill->toArray());
    }

    /** @test */
    public function updateSkill_updates_a_skill()
    {
        $createdSkill = $this->createSkill();

        $this->service->updateSkill($createdSkill->id, ['title' => 'FoobarLinux']);

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