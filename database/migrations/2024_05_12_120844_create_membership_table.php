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
        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('price_adults');
            $table->string('price_seniors');
            $table->string('price_teens');
            $table->string('price_family');
            $table->string('trr');
            $table->string('sklic');
            $table->string('namen');
            $table->string('prejemnik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
