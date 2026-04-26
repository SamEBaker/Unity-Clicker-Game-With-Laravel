<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'score')) {
                $table->integer('score')->default(0);
            }
            if (!Schema::hasColumn('users', 'high_score')) {
                $table->integer('high_score')->default(0);
            }
            if (!Schema::hasColumn('users', 'sprite')) {
                $table->integer('sprite')->default(0);
            }
            if (!Schema::hasColumn('users', 'score_increase')) {
                $table->integer('score_increase')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'score')) {
                $table->dropColumn('score');
            }
            if (Schema::hasColumn('users', 'high_score')) {
                $table->dropColumn('high_score');
            }
            if (Schema::hasColumn('users', 'sprite')) {
                $table->dropColumn('sprite');
            }
            if (Schema::hasColumn('users', 'score_increase')) {
                $table->dropColumn('score_increase');
            }
        });
    }
};