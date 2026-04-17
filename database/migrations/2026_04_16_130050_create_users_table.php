<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            
            $table->string('username')->unique();
            $table->string('full_name');
            $table->string('avatar_url')->nullable();
            $table->text('description')->nullable();
            
            // ←←←← ИСПРАВЛЕНИЕ ЗДЕСЬ ←←←←
            $table->foreignId('city_id')
                  ->nullable()                    // добавили nullable
                  ->constrained('cities')
                  ->onDelete('set null');
            
            $table->enum('role', ['user', 'admin'])->default('user');
            $table->boolean('is_banned')->default(false);
            $table->decimal('rating', 3, 2)->default(0.00);
            
            $table->timestamps();
            $table->rememberToken();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};