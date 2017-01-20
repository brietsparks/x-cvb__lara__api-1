<?php

namespace App\Models\Services\Exp;

use App\Models\Exp;
use App\Models\Services\ExpService;
use App\Models\Services\SkillService;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;

class ExpSkillService
{

    /**
     * @var SkillService
     */
    protected $skillService;

    /**
     * @var ExpService
     */
    protected $expService;

    /**
     * ExpSkillService constructor.
     * @param SkillService $skillService
     * @param ExpService $expService
     */
    public function __construct(SkillService $skillService, ExpService $expService)
    {
        $this->skillService = $skillService;
        $this->expService = $expService;
    }

    /**
     * @param $exp_id
     * @return Collection
     */
    public function getSkillsByExp($exp_id)
    {
        return Skill::whereHas('exps', function ($q) use ($exp_id) {
            $q->where('id', $exp_id);
        })->get();
    }

    /**
     * @param $skill_id
     * @param $exp_id
     * @return boolean
     */
    public function addSkillToExp($skill_id, $exp_id)
    {
        $skill = Skill::find($skill_id);

        /** @var Exp $exp */
        $exp = Exp::find($exp_id);

        if($skill && $exp) {
            $exp->skills()->attach($skill_id);
            return true;
        }
    }

    /**
     * @param $skill_id
     * @param $exp_id
     * @return bool
     */
    public function removeSkillFromExp($skill_id, $exp_id)
    {
        $skill = Skill::find($skill_id);

        /** @var Exp $exp */
        $exp = Exp::find($exp_id);

        if($skill && $exp) {
            $exp->skills()->detach($skill_id);
            return true;
        }
    }
}