<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('corners', function (Blueprint $table) {
            $table->id();
            $table->string('active');
            $table->foreignId('game_id')
                ->nullable()
                ->constrained('games')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->time('min')->nullable();
            $table->enum('half', ['first', 'second'])->nullable(); // lado da porta
            $table->time('hour')->nullable();
            $table->date('date')->nullable();
            $table->foreignId('championship_id')
                ->nullable()
                ->constrained('championships')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('favored_id')
                ->nullable()
                ->constrained('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('opponent_id')
                ->nullable()
                ->constrained('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('team_id')
                ->nullable()
                ->constrained('teams')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('code')->nullable();
            /*Log */
            $table->timestamps();
            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corners');
    }
};
