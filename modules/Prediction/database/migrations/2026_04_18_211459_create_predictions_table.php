<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('predictions', function (Blueprint $table) {
            $table->id();
            $table->string('type');           // Ex: BLOCO-001, COMBO-12-03
            $table->dateTime('expired')->nullable();
            $table->string('code')->unique();           // Ex: BLOCO-001, COMBO-12-03
            $table->string('hash')->unique();           // Ex: BLOCO-001, COMBO-12-03
            $table->tinyInteger('total_matches')->default(3);          // 3 ou 4
            // $table->tinyInteger('total_odds')->nullable();          // 3 ou 4

            $table->decimal('total_odds', $precision = 10, $scale = 2)->nullable();
            $table->decimal('total_prob', $precision = 10, $scale = 2)->nullable();
            // JSON com os jogos e previsões individuais
            $table->json('matches');   // ← Aqui vai o array com os 3/4 jogos
            $table->json('validation')->nullable();
            $table->enum('status', ['pending', 'won', 'lost'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predictions');
    }
};
