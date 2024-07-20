<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('user_borrower_id');
            $table->unsignedBigInteger('user_returner_id')->nullable();
            $table->unsignedBigInteger('librarian_borrower_id');
            $table->unsignedBigInteger('librarian_returner_id')->nullable();
            $table->timestamp('date_ser')->useCurrent();
            $table->timestamp('return_ser')->nullable();
            $table->enum('status', ['pendiente', 'devuelto']);
            $table->unsignedBigInteger('environment_id');

            // Foreign keys
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->foreign('user_borrower_id')->references('id')->on('borrower_users')->onDelete('cascade');
            $table->foreign('user_returner_id')->references('id')->on('borrower_users')->onDelete('cascade');
            $table->foreign('librarian_borrower_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('librarian_returner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('environment_id')->references('id')->on('environments')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
