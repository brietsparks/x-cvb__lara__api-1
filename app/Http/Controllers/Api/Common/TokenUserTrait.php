<?php

namespace App\Http\Controllers\Api\Common;

use App\Models\User;
use Illuminate\Auth\TokenGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Gets User and UserId from a Request object
 *
 * Class AccessesUserTrait
 * @package App\Http\Controllers\Api
 */
trait TokenUserTrait
{

    /**
     * Fetch the user id from the request bearer token
     *
     * @param Request $request
     * @return int
     */
    public function getTokenUserId(Request $request)
    {
        return $this->getTokenUser($request)->id;
    }

    /**
     * Fetch the user via the request bearer token
     *
     * @param Request $request
     * @return User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getTokenUser(Request $request)
    {
        if(!$this->user) {
            /** @var TokenGuard $guard */
            $guard = Auth::guard();

            $this->user = $guard->setRequest($request)->user();
        }

        return $this->user;
    }

}