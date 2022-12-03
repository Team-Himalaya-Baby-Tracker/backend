<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorMorphBabySizeHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('baby_size_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->string('creator_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('baby_size_histories', function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('creator_type');
        });
    }
}
