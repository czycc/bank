<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->boolean('enable')->default(0)->after('img_url');
            $table->unsignedInteger('download')->default(0)->after('enable');
            $table->unsignedInteger('weight')->default(0)->after('download');
        });
    }

    public function down()
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('enable');
            $table->dropColumn('download');
            $table->dropColumn('weight');
        });
    }
}
