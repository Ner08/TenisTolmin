<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
            $table->text('short_description');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        Schema::create('score_boards', function (Blueprint $table) {
            $table->id();
            $table->string('player_name');
            $table->integer('points')->nullable()->default(0);;
            $table->timestamps();
        });

        Schema::create('league_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('league_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->longText('content');
        });

        Schema::create('brackets', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('league_id');
            $table->string('name');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->longText('description');
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('bracket_id');
            $table->string('name')->nullable();
            $table->foreign('bracket_id')->references('id')->on('brackets')->onDelete('cascade');
            $table->string('p1_name');
            $table->integer('p1_score');
            $table->integer('p1_ranking');
            $table->string('p2_name')->nullable();
            $table->integer('p2_score')->nullable();
            $table->integer('p2_ranking')->nullable();
            $table->integer('team_score');
        });

        Schema::create('custom_match_ups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('bracket_id');
            $table->unsignedBigInteger('team1_id');
            $table->unsignedBigInteger('team2_id');
            $table->foreign('bracket_id')->references('id')->on('brackets')->onDelete('cascade');
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade');
            $table->integer('t1_first_set');
            $table->integer('t2_first_set');
            $table->integer('t1_second_set');
            $table->integer('t2_second_set');
            $table->integer('t1_third_set');
            $table->integer('t2_third_set');
            $table->integer('t1_sets_won')->nullable();
            $table->integer('t2_sets_won')->nullable();
            $table->boolean('quick_decider')->default(true);
            $table->integer('round')->nullable(); //TODO remove nullable
            $table->boolean('winner')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leagues');
        Schema::dropIfExists('score_boards');
        Schema::dropIfExists('league_comments');
        Schema::dropIfExists('brackets');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('custom_matchups');
    }
};
