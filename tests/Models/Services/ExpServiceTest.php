<?php

namespace tests\Models\Services;

use App\Models\Exp;
use App\Models\User;
use App\Models\Services\ExpService;

class ExpServiceTest extends ServiceTestCase
{

    /**
     * @var ExpService
     */
    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = \App::make(ExpService::class);
    }

    /** @test */
    public function saveExp_updates_an_existing_exp_and_returns_it()
    {
        // context
        $exp = factory(Exp::class)->create();
        $user = $exp->user();

        // sanity
        $this->seeInDatabase('exps', [
            'title' => $exp->title
        ]);

        // action
        $expData = $exp->toArray();
        $expData['title'] = $exp->title . "Changed";

        $returnedExp = $this->service->saveExp($expData, $user->id);

        // assert
        $this->seeInDatabase('exps', $expData);

        $this->assertEquals($returnedExp->title, $expData['title']);
    }

    /** @test */
    public function saveExp_creates_an_new_exp_and_returns_it()
    {
        // context
        $expData = factory(Exp::class)->make()->toArray();

        // sanity
        $this->dontSeeInDatabase('exps', $expData);

        // action
        $returnedExp = $this->service->saveExp($expData, $expData['user_id']);

        // assert
        $this->seeInDatabase('exps', $expData);
        $this->assertEquals($expData['title'], $returnedExp->title);
    }

    /** @test */
    public function getExpsByUserId_returns_exps_of_a_user()
    {
        // context
        $user = factory(User::class)->create();
        $exps = factory(Exp::class, 5)->create(['user_id' => $user->id]);

        // action
        $gottenExps = $this->service->getExpsByUserId($user->id);

        // assert
        $this->assertEquals(count($gottenExps), count($exps));
    }

    /** @test */
    public function getExpById_returns_exp_by_id()
    {
        // context
        $exp = factory(Exp::class)->create();

        // action
        $gottenExp = $this->service->getExpById($exp->id);

        // assert
        $this->assertEquals($exp->title, $gottenExp->title);
        $this->assertEquals($exp->id, $gottenExp->id);
    }

    /** @test */
    public function deleteExpById_soft_deletes_exp_by_id()
    {
        //context
        $exp = factory(Exp::class)->create();
        $user = $exp->user();

        // sanity
        $this->seeInDatabase('exps', $exp->toArray());

        // action
        $this->service->deleteExpById($exp->id);

        // assert
        $this->dontSeeInDatabase('exps', $exp->toArray());
    }

}