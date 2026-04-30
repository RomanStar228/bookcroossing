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
        Schema::create('book_requests', function (Blueprint $table) {
    $table->id();

    $table->foreignId('book_id')->constrained()->cascadeOnDelete();

    $table->foreignId('requester_id')
          ->constrained('users')
          ->cascadeOnDelete();

    $table->enum('status', [
    'pending',
    'approved',      // или 'accepted' — важно, чтобы совпадало
    'rejected',
    'cancelled',
    'completed'      // ← должно быть
    ])->default('pending');

    $table->timestamps();
});
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_requests');
    }
};
