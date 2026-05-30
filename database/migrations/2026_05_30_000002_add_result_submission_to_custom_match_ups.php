<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('custom_match_ups', function (Blueprint $table) {
            $table->enum('result_status', ['none', 'pending', 'confirmed', 'disputed', 'admin_review'])
                  ->default('none')
                  ->after('exception');
            $table->unsignedBigInteger('submitted_by_user_id')->nullable()->after('result_status');
            $table->foreign('submitted_by_user_id')->references('id')->on('users')->nullOnDelete();
            $table->timestamp('result_submitted_at')->nullable()->after('submitted_by_user_id');
        });
    }

    public function down(): void
    {
        Schema::table('custom_match_ups', function (Blueprint $table) {
            $table->dropForeign(['submitted_by_user_id']);
            $table->dropColumn(['result_status', 'submitted_by_user_id', 'result_submitted_at']);
        });
    }
};
