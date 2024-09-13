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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function ($table) {
                $table->string('discord_id')->nullable()->unique();
                $table->string('discord_username')->nullable();
                $table->string('discord_avatar')->nullable();
                $table->string('discord_token')->nullable();
                $table->string('discord_refresh_token')->nullable();
                $table->timestamp('discord_token_expires')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('discord_id');
            $table->dropColumn('discord_username');
            $table->dropColumn('discord_avatar');
            $table->dropColumn('discord_token');
            $table->dropColumn('discord_refresh_token');
            $table->dropColumn('discord_token_expires');
        });
    }
};
