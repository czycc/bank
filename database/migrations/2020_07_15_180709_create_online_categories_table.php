<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOnlineCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('online_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
//            $table->timestamps();
        });

        $category = [
            [
                'name' => '热门活动',
                'description' => ''
            ],[
                'name' => '人气产品',
                'description' => ''
            ],[
                'name' => '理财课堂',
                'description' => ''
            ],

        ];

        DB::table('online_categories')->insert($category);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('online_categories');
    }
}
