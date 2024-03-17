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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('email')->unique();
            $table->string('name');
            $table->string('password')->nullable();
            $table->string('type')->default("mentee");
            $table->string('breed')->nullable();
            $table->integer('age')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('socials', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->index()->references('id')->on('users');
            $table->string('type');
            $table->string('social_id')->unique();
            $table->string('access_token');
            $table->string('refresh_token');
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('socials');
        Schema::dropIfExists('sessions');
    }
};
