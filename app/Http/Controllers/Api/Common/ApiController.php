<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{

    use AccessesUserTrait;

    public function methodNotAllowed($data = null)
    {
        return new JsonResponse($data, 405);
    }

}