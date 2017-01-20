<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimespansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timespans', function(Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id')->unsigned();

            $table->date('start_canonical');
            $table->index('start_canonical');

            $table->smallInteger('start_year');
            $table->tinyInteger('start_month');
            $table->tinyInteger('start_day');

            $table->date('end_canonical');
            $table->index('end_canonical');

            $table->smallInteger('end_year');
            $table->tinyInteger('end_month');
            $table->tinyInteger('end_day');

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
        Schema::drop('timespans');
    }
}
