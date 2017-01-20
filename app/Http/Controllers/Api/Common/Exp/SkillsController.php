<?php

namespace App\Http\Controllers\Api\Common\Exp;

use App\Http\Controllers\Api\Common\ApiController;
use App\Models\Services\Exp\ExpSkillService;
use Illuminate\Http\Request;

class SkillsController extends ApiController
{

    /**
     * @var ExpSkillService
     */
    protected $service;

    /**
     * SkillsController constructor.
     * @param ExpSkillService $service
     */
    public function __construct(ExpSkillService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request, $expId)
    {
        return $this->service->getSkillsByExp($expId);
    }

    public function show()
    {
        // todo: common exp skills controller show
        return true;
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