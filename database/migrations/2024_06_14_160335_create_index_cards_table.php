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
        Schema::create('index_cards', function (Blueprint $table) {
            $table->id();
            $table->string('number', 60);
            $table->enum('status', ['activo', 'inactivo'])->default('activo');
            $table->unsignedBigInteger('program_id'); 
            $table->foreign('program_id')->references('id')->on('programs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('index_cards');
    }
};
