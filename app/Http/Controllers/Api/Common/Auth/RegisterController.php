<?php

namespace App\Http\Controllers\Api\Common\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        // todo: if not valid, return a json response with the errors
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        return JsonResponse::create($user);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6', //todo: create confirm pw field
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $apiToken = str_random(60);
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'api_token' => $apiToken
        ]);
    }
}