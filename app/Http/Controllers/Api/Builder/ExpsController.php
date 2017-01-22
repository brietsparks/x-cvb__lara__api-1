<?php

namespace App\Http\Controllers\Api\Builder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


use App\Http\Controllers\Api\Common\ExpsController as BaseExpController;

// builder/exps/
class ExpsController extends BaseExpController
{

    public function store(Request $request)
    {
        $userId = $this->getTokenUserId($request);

        if($request->get('id')) {
            // todo: error - trying to create exp with existing id
        }

        $expData = $request->all();

        $exp = $this->service->saveExp($expData, $userId);

        if($request->has('skills')) {
            $this->service->syncExp($exp, 'skills', $expData['skills']);
        }

        return new JsonResponse($exp);
    }

    public function destroy(Request $request, $id)
    {
        $user = $this->getTokenUser($request);
        if (!$user) {
            // todo: error - error fetching user
        }

        $exp = $user->exps()->where('id', $id)->first();
        if (!$exp) {
            // todo: error - error fetching exp
        }

        if ($user->cant('destroy', $exp)) {
            // todo: error - unauthorized access of resource
        }

        $deleted = $this->service->deleteExpById($id);

        return JsonResponse::create($deleted);
    }

    public function update(Request $request, $id)
    {
        $user = $this->getTokenUser($request);
        if (!$user) {
            // todo: error - error fetching user
        }

        $exp = $user->exps()->where('id', $id)->first();
        if (!$exp) {
            // todo: error - error fetching exp
        }

        if ($user->cant('update', $exp)) {
            // todo: error - unauthorized access of resource
        }

        $expData = $request->all();

        $exp = $this->service->saveExp($expData, $user->id);

        $this->service->syncExp($exp, 'skills', $expData['skills']);

        return $exp;

    }

}