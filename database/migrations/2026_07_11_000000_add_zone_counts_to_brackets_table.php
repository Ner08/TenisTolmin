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
        Schema::table('brackets', function (Blueprint $table) {
            $table->unsignedSmallInteger('green_rows')->nullable()->after('places_to');
            $table->unsignedSmallInteger('orange_rows')->nullable()->after('green_rows');
            $table->unsignedSmallInteger('red_rows')->nullable()->after('orange_rows');
        });
    }

    public function down(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            $table->dropColumn(['green_rows', 'orange_rows', 'red_rows']);
        });
    }
};
