<?php

namespace App\Http\Controllers\Api\Common\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\AuthManager;
use Illuminate\Auth\TokenGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    use AuthenticatesUsers; //, ThrottlesLogins;

    /**
     * @var AuthManager
     */
    protected $authManager;

    protected $inputKey = 'api_key';
    protected $storageKey = 'api_key';
    protected $throttle = false;

    /**
     * AuthController constructor.
     * @param AuthManager $authManager
     */
    public function __construct(AuthManager $authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * Authenticate a token and return the user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function authenticate(Request $request)
    {
        $result = $this->guard()->setRequest($request)->user();

        return JsonResponse::create($result);
    }

    /**
     * Authenticate login credentials and return the user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($this->throttle) {
            return $this->limitedLogin($request);
        } else {
            if ($user = $this->getAuthenticatedUser($request)) {
                return JsonResponse::create($user);
            }

            return JsonResponse::create(false);
        }
    }

    /**
     * Login with throttling
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function limitedLogin(Request $request)
    {
        if ($lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return JsonResponse::create(1);
        }

        // $credentials = $this->credentials($request);

        if ($user = $this->getAuthenticatedUser($request)) {
            return JsonResponse::create($user->toJson());
        }

        if (!$lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return JsonResponse::create(2);

    }

    /**
     * @param Request $request
     * @return User
     */
    public function getAuthenticatedUser(Request $request)
    {
        $sessionGuard = $this->sessionGuard();

        $credentials = $this->credentials($request);

        if($sessionGuard->validate($credentials)) {
            $userProvider = $sessionGuard->getProvider();

            $user = $userProvider->retrieveByCredentials($credentials);

            return $user;
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required',
            'password' => 'required',
        ]);
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * @return TokenGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function sessionGuard()
    {
        return $this->authManager->guard('web');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }
}