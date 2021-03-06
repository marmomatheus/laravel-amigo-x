<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_matches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('game_id');
            $table->foreign('game_id')->references('id')->on('games');  
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');  
            $table->unsignedInteger('friend_id');
            $table->foreign('friend_id')->references('id')->on('users');  
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
        Schema::dropIfExists('game_matches');
    }
}
