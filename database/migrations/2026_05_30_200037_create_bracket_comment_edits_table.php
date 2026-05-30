<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bracket_comment_edits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bracket_comment_id')->constrained('bracket_comments')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->text('previous_content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bracket_comment_edits');
    }
};
