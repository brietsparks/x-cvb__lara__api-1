<?php

use App\Models\Services\Exp\ExpSkillService;
use App\Models\Exp;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExpSkillServiceTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @var ExpSkillService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = \App::make(ExpSkillService::class);
    }

    protected function createUser()
    {
        return factory(User::class)->create();
    }

    protected function createExp()
    {
        return factory(Exp::class)->create();
    }

    protected function createSkill()
    {
        return factory(Skill::class)->create();
    }

    /** @test */
    public function getSkillsByExp_gets_skills_by_exp_id()
    {
        $exp = $this->createExp();
        $exp->save();

        $skill = $this->createSkill();
        $skill->save();

        $exp->skills()->attach($skill->id);

        $skills = $this->service->getSkillsByExp($exp->id)->toArray();

        $this->assertEquals([$skill->toArray()], $skills);
    }

    /** @test */
    public function addSkillToExp_adds_an_existing_skill_to_an_existing_exp()
    {
        $exp = $this->createExp();
        $exp->save();

        $skill = $this->createSkill();
        $skill->save();

        $result = $this->service->addSkillToExp($skill->id, $exp->id);

        $this->seeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function removeSkillFromExp_removes_an_existing_skill_from_an_existing_exp()
    {
        // setup
        $exp = $this->createExp();
        $exp->save();

        $skill = $this->createSkill();
        $skill->save();

        $exp->skills()->attach($skill->id);

        $this->seeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);

        //test
        $result = $this->service->removeSkillFromExp($skill->id, $exp->id);

        $this->dontSeeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);
    }
}