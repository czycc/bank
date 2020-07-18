<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('out_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('任务标题');
            $table->text('content')->comment('任务内容富文本');
            $table->string('scope')->comment('任务范围');
            $table->dateTime('start')->comment('开始时间');
            $table->dateTime('end')->comment('结束时间');
            $table->string('urgency')->comment('紧急状态');
            $table->boolean('enable');
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
        Schema::dropIfExists('out_tasks');
    }
}
