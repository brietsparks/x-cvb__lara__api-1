<?php

namespace App\Http\Controllers\Api\Common\User;

use App\Http\Controllers\Api\Common\ApiController;
use App\Models\Services\User\UserSkillService;
use Illuminate\Http\Request;

class SkillsController extends ApiController
{

    /**
     * @var UserSkillService
     */
    protected $service;

    public function __construct(UserSkillService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return $this->service->getUserSkills(
            $this->getTokenUserId($request)
        );
    }

    public function show(Request $request, $skill_id)
    {
       return $this->service->getUserSkill(
           $this->getTokenUserId($request),
           $skill_id
       );
    }

    public function store(Request $request)
    {
        return $this->methodNotAllowed();
    }

    public function update(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }

    public function destroy(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }

}