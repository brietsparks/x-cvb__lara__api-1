<?php

namespace App\Providers;

use App\Models\Exp;
use App\Models\Policies\ExpPolicy;
use App\Models\Policies\ModelPolicy;
use App\Models\Policies\SkillPolicy;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Model::class => ModelPolicy::class,
        Exp::class => ExpPolicy::class,
        Skill::class => SkillPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
