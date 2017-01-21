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