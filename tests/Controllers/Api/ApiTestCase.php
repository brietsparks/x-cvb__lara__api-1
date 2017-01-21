<?php

namespace tests\Controllers\Api;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use tests\ModelHelpers;

class ApiTestCase extends \TestCase
{

    use ModelHelpers;
    use DatabaseTransactions;

    protected $uriPrefix = '/api/v0';

    public function setUp()
    {
        parent::setUp();
    }

    public function persistAuthUser()
    {
        $user = $this->createAuthUser();

        return $user;
    }

}