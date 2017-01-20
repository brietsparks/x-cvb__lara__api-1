<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exps', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();
            $table->integer('user_id')->unsigned();

            // id of the parent Exp (tree structure)
            $table->integer('parent_id')->unsigned()->nullable();

            // id of the next Exp for ordering in singly linked list
            $table->integer('next_id')->unsigned()->nullable();

            // the type of Exp
            $table->string('type');

            // descriptive phrase
            $table->string('title');

            // descriptive phrase
            $table->string('subtitle');

            // descriptive sentence
            $table->string('summary')->nullable();

            // other
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exps');
    }
}
