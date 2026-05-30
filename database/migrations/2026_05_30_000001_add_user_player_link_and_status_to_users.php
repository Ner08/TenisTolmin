<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('player_id')->nullable()->after('is_admin');
            $table->foreign('player_id')->references('id')->on('players')->nullOnDelete();
            $table->enum('registration_status', ['pending', 'approved', 'rejected'])
                  ->default('approved')
                  ->after('player_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['player_id']);
            $table->dropColumn(['player_id', 'registration_status']);
        });
    }
};
