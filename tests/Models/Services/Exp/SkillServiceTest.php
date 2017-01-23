<?php

namespace tests\Models\Services\Exp;

use App\Models\Services\Exp\ExpSkillService;
use App\Models\Exp;
use App\Models\Skill;
use App\Models\User;
use tests\Models\Services\ServiceTestCase;

class SkillServiceTest extends ServiceTestCase
{

    /**
     * @var ExpSkillService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = \App::make(ExpSkillService::class);
    }

    /** @test */
    public function getSkillsByExp_gets_skills_by_exp_id()
    {
        // context
        $exp = factory(Exp::class)->create();
        $skill = factory(Skill::class)->create();
        $exp->skills()->attach($skill->id);

        // action
        $skills = $this->service->getSkillsByExp($exp->id)->toArray();

        // assert
        $this->assertEquals([$skill->toArray()], $skills);
    }

    /** @test */
    public function addSkillToExp_adds_an_existing_skill_to_an_existing_exp()
    {
        // context
        $exp = factory(Exp::class)->create();
        $skill = factory(Skill::class)->create();

        // action
        $result = $this->service->addSkillToExp($skill->id, $exp->id);

        // assert
        $this->seeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);

        $this->assertTrue($result);
    }

    /** @test */
    public function removeSkillFromExp_removes_an_existing_skill_from_an_existing_exp()
    {
        // context
        $exp = factory(Exp::class)->create();
        $skill = factory(Skill::class)->create();
        $exp->skills()->attach($skill->id);

        // sanity
        $this->seeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);

        // action
        $result = $this->service->removeSkillFromExp($skill->id, $exp->id);

        // assert
        $this->dontSeeInDatabase('exp_skill',[
            'skill_id' => $skill->id,
            'exp_id' => $exp->id
        ]);

        $this->assertTrue($result);
    }
}