<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Города
        $this->call(CitySeeder::class);

        // 2. Жанры
        $this->call(GenreSeeder::class);

        // 3. Создаём администратора (только если ещё не существует)
        if (!User::where('email', 'admin@bookcrosser.ru')->exists()) {
            User::create([
                'username'    => 'admin',
                'full_name'   => 'Администратор',
                'email'       => 'admin@bookcrosser.ru',
                'password'    => bcrypt('password'),
                'city_id'     => City::first()->id ?? 1,
                'role'        => 'admin',
                'is_banned'   => false,
                'rating'      => 5.00,
                'description' => 'Главный администратор платформы BookCrosser',
            ]);
            echo "✅ Создан администратор (admin@bookcrosser.ru)\n";
        } else {
            echo "ℹ️  Администратор уже существует\n";
        }

        // 4. Создаём тестового пользователя
        if (!User::where('email', 'test@bookcrosser.ru')->exists()) {
            User::create([
                'username'    => 'testuser',
                'full_name'   => 'Тестовый Пользователь',
                'email'       => 'test@bookcrosser.ru',
                'password'    => bcrypt('password'),
                'city_id'     => City::first()->id ?? 1,
                'role'        => 'user',
                'is_banned'   => false,
                'rating'      => 0.00,
            ]);
            echo "✅ Создан тестовый пользователь (test@bookcrosser.ru)\n";
        } else {
            echo "ℹ️  Тестовый пользователь уже существует\n";
        }

        echo "\n🎉 Database seeded successfully!\n";
        echo "   Логин администратора: admin@bookcrosser.ru / password\n";
        echo "   Логин тестового пользователя: test@bookcrosser.ru / password\n";
    }
}