<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('index_card_id');
            $table->foreign('index_card_id')->references('id')->on('index_cards')->onDelete('cascade');
            $table->unsignedBigInteger('user_rel_id');
            $table->foreign('user_rel_id')->references('id')->on('borrower_users')->onDelete('cascade');
            $table->timestamps();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('relationships');
    }
};
