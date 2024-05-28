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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('year');
            $table->string('price_adults');
            $table->string('price_seniors');
            $table->string('price_students');
            $table->string('price_kids');
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
        Schema::dropIfExists('memberships');
    }
};
