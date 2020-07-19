<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draw_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('draw_id');
            $table->string('reward');
            $table->string('reward_bg');
            $table->unsignedInteger('stock');
            $table->unsignedInteger('odds');
            $table->unsignedInteger('out')->default(0);
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
        Schema::dropIfExists('draw_items');
    }
}
