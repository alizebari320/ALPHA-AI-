<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('saved_tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('tool_key', 120);
            $table->string('tool_name', 160);
            $table->string('category', 60)->nullable();
            $table->timestamps();
            $table->unique(['user_id', 'tool_key']);
        });

        Schema::create('prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title', 160);
            $table->text('body');
            $table->string('category', 60)->default('general');
            $table->string('locale', 20)->default('en');
            $table->string('tool_key', 120)->nullable();
            $table->boolean('is_public')->default(false);
            $table->unsignedInteger('copy_count')->default(0);
            $table->timestamps();
            $table->index(['category', 'locale', 'is_public']);
        });

        Schema::create('saved_prompts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('prompt_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['user_id', 'prompt_id']);
        });

        Schema::create('analytics_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event', 80);
            $table->string('path', 500)->nullable();
            $table->string('entity_type', 60)->nullable();
            $table->string('entity_key', 160)->nullable();
            $table->json('metadata')->nullable();
            $table->string('session_hash', 64)->nullable();
            $table->timestamps();
            $table->index(['event', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics_events');
        Schema::dropIfExists('saved_prompts');
        Schema::dropIfExists('prompts');
        Schema::dropIfExists('saved_tools');
    }
};
