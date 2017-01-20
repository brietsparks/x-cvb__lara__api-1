<?php

namespace App\Http\Controllers\Api\Common;

use App\Models\Services\SkillService;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillsController extends ApiController
{

    /**
     * @var SkillService
     */
    protected $service;

    /**
     * SkillsController constructor.
     * @param SkillService $service
     */
    public function __construct(SkillService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return Skill::all();
    }

    public function show($id)
    {
        $skill = $this->service->getSkillById($id);

        return new JsonResponse($skill->toArray());
    }

    public function store(Request $request)
    {
        return $this->methodNotAllowed();
    }

    public function update(Request $request, $id)
    {
        return $this->methodNotAllowed();
    }

    public function destroy($id)
    {
        return $this->methodNotAllowed();
    }

}
