<?php

namespace tests\Controllers\Api\Common;

use tests\Controllers\Api\ApiTestCase;

class ExpControllerTest extends ApiTestCase
{

    public function uri()
    {
        return $this->uriPrefix . "/exps";
    }

    /** @test */
    public function index_returns_json_containing_exps_by_user_id()
    {
        $user = $this->createAuthUser();

        $r = $this->getJson($uri = $this->uri(), ['user_id' => 'foo']);

        print_r(
//            $this->uri()
            $this->response->getOriginalContent()
        );
    }

}