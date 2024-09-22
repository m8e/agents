<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        // Create agents table
        Schema::create('agents', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['ai', 'human', 'bot'])->default('ai');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            $table->json('config')->nullable();
            $table->json('capabilities')->nullable();

            $table->timestamp('last_active_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('team_id');
            $table->index('status');
            $table->index('type');
        });

        // Create activity_logs table
        Schema::create('activity_logs', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');
            $table->string('activity_type');
            $table->string('related_object_type'); // 'objective', 'milestone', 'agent'
            $table->unsignedBigInteger('related_object_id');
            $table->text('details')->nullable();
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['team_id', 'related_object_type', 'related_object_id'], 'team_related_object_index');
        });

        // Create comments table
        Schema::create('comments', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('parent_id')->nullable()->constrained('comments')->onDelete('cascade');
            $table->string('related_object_type'); // 'objective', 'milestone'
            $table->unsignedBigInteger('related_object_id');
            $table->text('comment_text');
            $table->timestamps();

            // Indexes for faster queries
            $table->index(['related_object_type', 'related_object_id']);
        });

        // Create objectives table
        Schema::create('goals', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_id')->constrained('teams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('agent_id')->nullable()->constrained('agents')->onDelete('set null');

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->dateTime('start_date')->default(now());
            $table->dateTime('deadline_date')->nullable();

            $table->integer('progress')->default(0);
            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->enum('priority', ['critical', 'high', 'normal', 'low', 'backlog'])->default('normal');
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('low');

            $table->integer('estimated_tokens')->nullable();
            $table->integer('actual_tokens')->nullable();

            $table->text('outcome')->nullable();
            $table->string('tags')->nullable();
            $table->text('completion_criteria')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        // Create objective milestones table
        Schema::create('tasks', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('goal_id')->constrained()->onDelete('cascade');
            $table->foreignId('assigned_to')->nullable()->constrained('agents')->onDelete('set null');

            $table->string('title');
            $table->integer('progress')->default(0);

            $table->enum('status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->enum('priority', ['critical', 'high', 'medium', 'low'])->default('medium');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
