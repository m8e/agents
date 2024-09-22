<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('llm_messages', function (Blueprint $table): void {
            $table->id(); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->foreignId('agent_id')->constrained()->onDelete('cascade'); // Foreign key to agents
            $table->foreignId('goal_id')->nullable()->constrained('goals')->onDelete('cascade'); // Foreign key to goals
            $table->foreignId('task_id')->nullable()->constrained('tasks')->onDelete('cascade'); // Foreign key to tasks
            $table->enum('sender', ['user', 'llm']); // Message sender
            $table->text('message'); // Message content
            $table->json('metadata')->nullable(); // Optional metadata
            $table->timestamps(); // Created and updated timestamps
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('llm_messages');
    }
};
