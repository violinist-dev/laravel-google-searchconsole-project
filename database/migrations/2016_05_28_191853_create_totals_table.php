<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('totals', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('site_id')->unsigned();
            $table->foreign('site_id')->references('id')->on('sites');

            $table->date('month');
            $table->integer('clicks')->unsigned();
            $table->integer('impressions')->unsigned();
            $table->decimal('ctr', 5, 2);
            $table->decimal('position', 5, 1);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('totals');
    }
}
