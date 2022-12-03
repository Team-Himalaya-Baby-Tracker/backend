<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatorMorphBabiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->unsignedBigInteger('creator_id')->nullable()->after('gender');
            $table->string('creator_type')->nullable()->after('creator_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('babies', function (Blueprint $table) {
            $table->dropColumn('creator_id');
            $table->dropColumn('creator_type');
        });
    }
}
