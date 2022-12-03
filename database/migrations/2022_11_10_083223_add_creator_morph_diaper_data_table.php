<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorMorphDiaperDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('diaper_data', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable()->change();
            $table->string('creator_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('diaper_data', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable(false)->change();
            $table->string('creator_type')->nullable(false)->change();
        });
    }
}
