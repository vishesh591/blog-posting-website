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
            $table->string('role')->default('reader')->after('email');
            $table->string('headline')->nullable()->after('role');
            $table->string('avatar')->nullable()->after('headline');
            $table->text('bio')->nullable()->after('avatar');
            $table->json('social_links')->nullable()->after('bio');
            $table->timestamp('last_seen_at')->nullable()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'headline',
                'avatar',
                'bio',
                'social_links',
                'last_seen_at',
            ]);
        });
    }
};
