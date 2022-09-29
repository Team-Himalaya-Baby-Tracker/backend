<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('diaper_data', function (Blueprint $table) {
            $table->string('wet_type');
        });
    }

    public function down()
    {
        Schema::table('diaper_data', function (Blueprint $table) {
            $table->dropColumn('wet_type');
        });
    }
};
