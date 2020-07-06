<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->comment('任务标题');
            $table->text('content')->comment('任务内容富文本');
            $table->string('scope')->comment('任务范围');
            $table->string('category')->comment('任务类型');
            $table->timestamp('end')->comment('结束时间');
            $table->string('urgency')->comment('紧急状态');
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
        Schema::dropIfExists('tasks');
    }
}
