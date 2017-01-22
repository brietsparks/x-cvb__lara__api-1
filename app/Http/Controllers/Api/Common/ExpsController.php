<?php

namespace App\Http\Controllers\Api\Common;

use App\Models\Exp;
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
        // not allowed to get all
        return $this->methodNotAllowed();
    }

    public function show($id)
    {
        return Exp::find($id);
    }

    public function store(Request $request)
    {
        // not allowed to create in common (only builder)
        return $this->methodNotAllowed();
    }

    public function update(Request $request, $id)
    {
        // not allowed to update in common (only builder)
        return $this->methodNotAllowed();
    }

    public function destroy(Request $request, $id)
    {
        // not allowed to delete in common (only builder)
        return $this->methodNotAllowed();
    }

}