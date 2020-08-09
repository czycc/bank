<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('job_num')->comment('工号');
            $table->string('unit')->comment('单位信息');
            $table->string('department')->comment('所属部门');
            $table->string('job')->comment('职务');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('wx_avatar')->nullable()->comment('头像');
            $table->unsignedBigInteger('scope_id')->default(2);
//            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
