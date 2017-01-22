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

//    /** @test */
    public function show_returns_exp_by_id_via_json_response()
    {
        /** @var User $authUser */
        $authUser = $this->createAuthUser();

        /** @var Exp $exp */
        $exp = $this->createExp();

        $uri = $this->uri() . $exp->id;

        $result = $this->getJson(
             $uri, $this->addAuth($authUser)
        )->response->getContent();

        $exp = $exp->toArray();
        $result = json_decode($result, true);

        $this->assertEquals($exp['id'], $result['id']);
        $this->assertEquals($exp['user_id'], $result['user_id']);
        $this->assertEquals($exp['title'], $result['title']);
    }

    /** @test */
    public function index_returns_401_responses()
    {
        /** @var User $authUser */
        $authUser = $this->createAuthUser();

        $uri = $this->uri();

        $status = $this->getJson(
            $uri, $this->addAuth($authUser)
        )->response->getStatusCode();

        $this->assertEquals(405, $status);
    }


    public function store_persists_exp_and_returns_it_via_json_response()
    {
        /** @var User $authUser */
        $authUser = $this->createAuthUser();

        // create the exp
        $exp = $this->createExp();
        $exp = $exp->toArray();

        // create a skill
        $skill = $this->createSkill();
        $skill->save();

        // attach the skill
        $exp['skills'] = [$skill->id];

        print_r([
            $exp
        ]);

        // send request
        $this->postJson($this->uri(), $exp, $this->addAuth($authUser));

        // get the response
        $result = json_decode($this->response->getContent(), true);


        // assertions
        $this->assertEquals($exp['id'], $result['id']);
        $this->assertEquals($exp['user_id'], $result['user_id']);

        print_r($result);
    }

}