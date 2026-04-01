<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('player_id')->constrained()->onDelete('cascade');
            $table->integer('number');
            $table->boolean('is_prime');
            $table->string('user_answer', 20); // 'prime' or 'composite'
            $table->boolean('is_correct');
            $table->string('divisors')->nullable(); // comma-separated
            $table->timestamp('played_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
