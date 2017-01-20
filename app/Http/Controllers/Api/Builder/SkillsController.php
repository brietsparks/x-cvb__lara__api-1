<?php

namespace App\Http\Controllers\Api\Builder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\Common\SkillsController as BaseSkillsController;

class SkillsController extends BaseSkillsController
{

    public function store(Request $request)
    {
        $userId = $this->getUser($request)->id;

        $skill = $this->service->createSkill($request->all(), $userId);

        // todo: can skill be returned without this line
        return new JsonResponse($skill->toArray());
    }
    
    public function update(Request $request, $id)
    {
        $skill = $this->service->updateSkill($id, $request->all());

        // todo: can skill be returned without this line
        return new JsonResponse($skill->toArray());
    }

}
