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
        Schema::table('conversation_participants', function (Blueprint $table) {
            // Add unique constraint on (conversation_id, user_id)
            $table->unique(['conversation_id', 'user_id'], 'conversation_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversation_participants', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique('conversation_user_unique');
        });
    }
};
