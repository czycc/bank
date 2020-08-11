<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBecksRanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('becks_ranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('location');
            $table->string('openid');
            $table->string('nickname');
            $table->string('avatar');
            $table->unsignedBigInteger('rank');
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
        Schema::dropIfExists('becks_ranks');
    }
}
