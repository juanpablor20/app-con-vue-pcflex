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
        Schema::create('borrower_users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('last_name', 60);
            $table->string('type_identification', 60);
            $table->string('number_identification', 60)->unique();
            $table->string('sex_user', 60);
            $table->string('gender_sex', 60);
            $table->string('roll', 60);
            $table->enum('status', ['activo', 'conEquipo', 'inactivo', 'reportado'])->default('activo');
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('borrower_users');
    }
};
