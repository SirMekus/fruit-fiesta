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
        Schema::table('games', function (Blueprint $table) {
            $table->json('symbol')->nullable()->after('point');
            $table->string('prize_type')->nullable()->after('prize_id');
            $table->float('prizeamount')->nullable()->after('prize_type');
            $table->string('popup_image')->nullable()->after('prizeamount');
            $table->float('points_band')->nullable()->after('prize_id');
            $table->string('message')->nullable()->after('points_band');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['symbol', 'prize_type', 'prizeamount', 'popup_image', 'points_band', 'message']);
        });
    }
};
