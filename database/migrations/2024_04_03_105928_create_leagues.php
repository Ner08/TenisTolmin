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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('p_name');
            $table->integer('points')->default(0);
            $table->boolean('is_fake')->default(false);
        });

        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('description');
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
            $table->string('tag')->nullable();
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->longText('b_description')->nullable();
            $table->text('points_description')->nullable();
            $table->boolean('is_group_stage')->default(false);
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('bracket_id');
            $table->unsignedBigInteger('p1_id');
            $table->unsignedBigInteger('p2_id')->nullable();
            $table->foreign('bracket_id')->references('id')->on('brackets')->onDelete('cascade');
            $table->foreign('p1_id')->references('id')->on('players')->onDelete('cascade');
            $table->foreign('p2_id')->references('id')->on('players')->onDelete('cascade')->nullable();
            $table->boolean('is_fake')->default(0);
        });

        Schema::create('custom_match_ups', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('bracket_id');
            $table->unsignedBigInteger('team1_id');
            $table->unsignedBigInteger('team2_id');
            $table->foreign('bracket_id')->references('id')->on('brackets')->onDelete('cascade');
            $table->foreign('team1_id')->references('id')->on('teams')->onDelete('cascade')->default(1);
            $table->foreign('team2_id')->references('id')->on('teams')->onDelete('cascade')->default(1);
            $table->integer('t1_first_set')->nullable();
            $table->integer('t2_first_set')->nullable();
            $table->integer('t1_second_set')->nullable();
            $table->integer('t2_second_set')->nullable();
            $table->integer('t1_third_set')->nullable();
            $table->integer('t2_third_set')->nullable();
            $table->string('t1_tag')->nullable();
            $table->string('t2_tag')->nullable();
            $table->integer('round');
            $table->string('exception')->nullable();
        });

        Schema::create('league_news', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('league_id');
            $table->foreign('league_id')->references('id')->on('leagues')->onDelete('cascade');
            $table->text('title');
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('leagues');
        Schema::dropIfExists('score_boards');
        Schema::dropIfExists('league_comments');
        Schema::dropIfExists('brackets');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('custom_matchups');
        Schema::dropIfExists('league_news');
    }
};
