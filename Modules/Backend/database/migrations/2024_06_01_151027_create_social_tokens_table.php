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
        Schema::create('social_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('social_provider', 10)->index();
            $table->string('social_id', 100)->index();
            $table->string('social_token', 500)->nullable();
            $table->string('social_refresh_token', 500)->nullable();
            $table->string('social_expires_in', 100)->nullable();
            $table->unique(['user_id', 'social_provider']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_tokens');
    }
};
