<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->foreignId('owner_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            $table->string('title');
            $table->string('author');
            $table->string('isbn')->nullable()->unique();

            // ИСПРАВЛЕНИЕ: genre_id должен быть nullable при onDelete('set null')
            $table->foreignId('genre_id')
                  ->nullable()                    // ←←← ЭТО ОБЯЗАТЕЛЬНО
                  ->constrained('genres')
                  ->onDelete('set null');

            $table->text('description')->nullable();
            $table->string('cover_image_url')->nullable();

            $table->enum('status', ['Отдаю', 'Ищу', 'Забронирована', 'Обменяна'])
                  ->default('Отдаю');

            $table->foreignId('city_id')
                  ->nullable()                    // ←←← тоже лучше сделать nullable
                  ->constrained('cities')
                  ->onDelete('set null');

            $table->string('condition')->nullable();
            $table->boolean('is_public')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};