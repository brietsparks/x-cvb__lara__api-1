<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpSkillPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_skill', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('exp_id')->unsigned()->index();
            $table->foreign('exp_id')->references('id')->on('exps')->onDelete('cascade');
            $table->integer('skill_id')->unsigned()->index();
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->primary(['exp_id', 'skill_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exp_skill');
    }
}
