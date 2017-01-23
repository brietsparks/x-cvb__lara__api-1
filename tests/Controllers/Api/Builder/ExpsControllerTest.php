<?php

namespace tests\Controllers\Api\Builder;

use App\Models\Exp;
use App\Models\Skill;
use App\Models\User;
use tests\Controllers\Api\RestApiTestCase;

class ExpsControllerTest extends RestApiTestCase
{

    public function uri()
    {
        return $this->uriPrefix . "/builder/exps/";
    }

    /** @test */
    public function unauthenticated_user_gets_401_responses()
    {
        $uri = $this->uri();

        // index
        $status = $this->getJson($uri)->response->getStatusCode();
        $this->assertEquals(401, $status);

        // read
        $status = $this->getJson($uri . '5')->response->getStatusCode();
        $this->assertEquals(401, $status);

        // create
        $status = $this->postJson($uri)->response->getStatusCode();
        $this->assertEquals(401, $status);

        // update
        $status = $this->putJson($uri . '5')->response->getStatusCode();
        $this->assertEquals(401, $status);

        // delete
        $status = $this->deleteJson($uri . '5')->response->getStatusCode();
        $this->assertEquals(401, $status);
    }

    /** @test */
    public function show_returns_exp_by_id_via_json_response()
    {
        // context
        /** @var User $authUser */
        $authUser = $this->createAuthUser();

        /** @var Exp $exp */
        $exp = factory(Exp::class)->create()->toArray();

        $uri = $this->uri() . $exp['id'];

        // action
        $result = $this->getJson(
             $uri, $this->addAuth($authUser)
        )->response->getContent();

        // assert
        $result = json_decode($result, true);

        $this->assertEquals($exp['id'], $result['id']);
        $this->assertEquals($exp['user_id'], $result['user_id']);
        $this->assertEquals($exp['title'], $result['title']);
    }

    /** @test */
    public function index_returns_405_responses()
    {
        // context
        /** @var User $authUser */
        $authUser = $this->createAuthUser();
        $uri = $this->uri();

        // action
        $status = $this->getJson(
            $uri, $this->addAuth($authUser)
        )->response->getStatusCode();

        // assert
        $this->assertEquals(405, $status);
    }

    /** @test */
    public function store_persists_exp_and_returns_it_via_json_response()
    {
        // context
        $authUser = $this->createAuthUser();

        $exp = factory(Exp::class)->make(['user_id' => $authUser->id])->toArray();
        $skill = factory(Skill::class)->create()->toArray();

        $exp['skills'] = [$skill];

        // send request
        $this->postJson($this->uri(), $exp, $this->addAuth($authUser));

        // get the response
        $result = json_decode($this->response->getContent(), true);

        print_r($result);


        // assertions
//        $this->assertEquals($exp['id'], $result['id']);
//        $this->assertEquals($exp['user_id'], $result['user_id']);

    }

}