<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id'); //user id of the user who played the game
            $table->foreignId('campaign_id')->nullable();
            $table->json('spin')->nullable();
            $table->float('point')->default(0);
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
        Schema::dropIfExists('spins');
    }
};
