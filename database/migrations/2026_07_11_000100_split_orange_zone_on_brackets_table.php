<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            // orange_up_rows  = band just below green (qualification to advance)
            // orange_down_rows = band just above red  (qualification to stay)
            $table->unsignedSmallInteger('orange_up_rows')->nullable()->after('green_rows');
            $table->unsignedSmallInteger('orange_down_rows')->nullable()->after('orange_up_rows');
        });

        // The previous single orange band sat just above red -> preserve it as the "down" band.
        DB::table('brackets')->update(['orange_down_rows' => DB::raw('orange_rows')]);

        Schema::table('brackets', function (Blueprint $table) {
            $table->dropColumn('orange_rows');
        });
    }

    public function down(): void
    {
        Schema::table('brackets', function (Blueprint $table) {
            $table->unsignedSmallInteger('orange_rows')->nullable()->after('green_rows');
        });

        DB::table('brackets')->update(['orange_rows' => DB::raw('orange_down_rows')]);

        Schema::table('brackets', function (Blueprint $table) {
            $table->dropColumn(['orange_up_rows', 'orange_down_rows']);
        });
    }
};
