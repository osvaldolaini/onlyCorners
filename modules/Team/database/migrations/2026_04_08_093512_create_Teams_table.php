<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('Teams', function (Blueprint $table) {
            $table->id();
            $table->string('active');
            $table->integer('sofascore_id');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('nick')->nullable();
            $table->string('country')->nullable();
            $table->string('code')->nullable();
            $table->string('logo_path')->nullable();

            $table->string('updated_by', 50)->nullable();
            $table->string('created_by', 50)->nullable();
            /*Excluido */
            $table->date('deleted_at')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Teams');
    }
};
