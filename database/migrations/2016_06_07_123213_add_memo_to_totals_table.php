<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMemoToTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('totals', function (Blueprint $table) {
            $table->string('memo')->nullable();
            $table->dateTime('memo_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('totals', function (Blueprint $table) {
            $table->dropColumn('memo');
            $table->dropColumn('memo_at');
        });
    }
}
