<?php

namespace App\Http\Controllers\Api\Builder\User;

use Illuminate\Http\Request;


use App\Http\Controllers\Api\Common\User\SkillsController as BaseSkillsController;

class SkillsController extends BaseSkillsController
{

    public function store(Request $request)
    {
        return $this->service->addSkillToUser(
            $request->all(),
            $this->getTokenUserId($request)
        );
    }

    public function update($user_id, Request $request, $skill_id)
    {

    }

    public function destroy(Request $request, $skill_id)
    {
        $this->service->removeSkillFromUser(
            $skill_id,
            $this->getTokenUserId($request)
        );
    }

}