<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpTimespanPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_timespan', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->integer('exp_id')->unsigned()->index();
            $table->foreign('exp_id')->references('id')->on('exps')->onDelete('cascade');
            $table->integer('timespan_id')->unsigned()->index();
            $table->foreign('timespan_id')->references('id')->on('timespans')->onDelete('cascade');
            $table->primary(['exp_id', 'timespan_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exp_timespan');
    }
}
