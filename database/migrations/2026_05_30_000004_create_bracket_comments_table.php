<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bracket_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('bracket_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('bracket_id')->references('id')->on('brackets')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
            $table->text('content');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bracket_comments');
    }
};
