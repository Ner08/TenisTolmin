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
            $table->unsignedSmallInteger('places_from')->nullable()->after('points_description');
            $table->unsignedSmallInteger('places_to')->nullable()->after('places_from');
        });
    }

    public function down(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            $table->dropColumn(['places_from', 'places_to']);
        });
    }
};
