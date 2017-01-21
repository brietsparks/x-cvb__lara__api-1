<?php

namespace App\Http\Controllers\Api\Common;

use App\Models\Services\ExpService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class ExpsController extends ApiController
{

    /**
     * @var User
     */
    protected $user;

    /**
     * @var ExpService
     */
    protected $service;

    public function __construct(ExpService $service)
    {
        $this->middleware('auth');

        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    public function index(Request $request)
    {
        $userId = $request->query('user_id');

        print_r($request->toArray());

        return $userId;

        return $this->service->getExpsByUserId($userId, false);
    }

    public function show($id)
    {
        // todo: common exp controller show
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