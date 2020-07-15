<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColsToOnlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('onlines', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->after('enable')->default(1);
            $table->dropColumn('scope');
            $table->dropColumn('board');
            $table->string('banner')->nullable();
            $table->unsignedBigInteger('scope_id')->after('category_id')->default(1);
            $table->unsignedBigInteger('weight')->default(0)->after('scope_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('onlines', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->string('scope');
            $table->string('board');
            $table->dropColumn('banner');
            $table->dropColumn('scope_id');
            $table->dropColumn('weight');
        });
    }
}
