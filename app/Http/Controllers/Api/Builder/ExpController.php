<?php

namespace App\Http\Controllers\Api\Builder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


use App\Http\Controllers\Api\Common\ExpController as BaseExpController;

class ExpController extends BaseExpController
{

    public function store(Request $request)
    {
        $userId = $this->getUserId($request);

        if($request->get('id')) {
            // todo: error - trying to create exp with existing id
        }

        $expData = $request->all();

        $exp = $this->service->saveExp($expData, $userId);

        if($request->has('skills')) {
            $this->service->syncExp($exp, 'skills', $expData['skills']);
        }

        return $exp;
    }

    public function update(Request $request)
    {
        $user = $this->getUser($request);

        $expId = $request->get('id');

        if (!$expId) {
            // todo: error - trying to update exp without id
        }

        $exp = $user->exps()->where('id', $expId)->first();

        if (!$exp) {
            // todo: error - trying to update non-owned exp
        }

        $expData = $request->all();

        $exp = $this->service->saveExp($expData, $user->id);

        $this->service->syncExp($exp, 'skills', $expData['skills']);

        return $exp;

    }

    public function destroy(Request $request, $id)
    {
        try {

            $user = $this->getUser($request);

            $exp = $user->exps()->where('id', $id)->first();

            if (!$exp) {
                // todo: error - trying to delete non-owned exp
            }

            $deleted = $this->service->deleteExpById($id);

            if ($deleted) {
                JsonResponse::create($deleted);
            } else {
                // todo: not deleted
            }

        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

}