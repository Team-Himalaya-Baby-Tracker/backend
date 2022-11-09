<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBabySitterRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baby_sitter_ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('baby_sitter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating');
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
        Schema::dropIfExists('baby_sitter_ratings');
    }
}
