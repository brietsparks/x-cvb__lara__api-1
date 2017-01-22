<?php

namespace tests\Controllers\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use tests\ModelHelpers;

class RestApiTestCase extends \TestCase
{

    use ModelHelpers;
    use DatabaseTransactions;

    protected $uriPrefix = '/api/rest/v0';

    public function setUp()
    {
        parent::setUp();
    }

    public function persistAuthUser()
    {
        $user = $this->createAuthUser();

        return $user;
    }

    /**
     * Add auth bearer token to headers array by ref
     *
     * @param User $authUser
     * @param array $headers
     * @return array
     */
    public function addAuth(User $authUser, array &$headers = [])
    {
        $headers['Authorization'] = 'Bearer ' . $authUser->api_token;

        return $headers;
    }

}