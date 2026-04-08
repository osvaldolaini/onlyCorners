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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100)->nullable();
            $table->string('acronym', 50)->nullable();
            $table->string('logo_path', 100)->nullable();
            $table->string('slug', 150)->nullable();
            $table->string('updated_by', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('cellphone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('telegram')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('number')->nullable();
            $table->string('address')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('complement')->nullable();
            $table->string('image')->nullable();

            $table->longText('about')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->string('video_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
