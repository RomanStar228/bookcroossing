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
        // 1. Создаём города (если ещё не созданы)
        $this->call(CitySeeder::class);

        // 2. Создаём жанры (позже добавим GenreSeeder)
        // $this->call(GenreSeeder::class);

        // 3. Создаём тестового администратора
        User::create([
            'username'    => 'admin',
            'full_name'   => 'Администратор',
            'email'       => 'admin@bookcrosser.ru',
            'password'    => bcrypt('password'),   // пароль: password
            'city_id'     => City::first()->id ?? 1, // берём первый город
            'role'        => 'admin',
            'is_banned'   => false,
            'rating'      => 5.00,
            'description' => 'Главный администратор платформы BookCrosser',
        ]);

        // 4. Создаём обычного тестового пользователя
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

        echo "✅ Database seeded successfully!\n";
        echo "   Логин администратора: admin@bookcrosser.ru / password\n";
        echo "   Логин тестового пользователя: test@bookcrosser.ru / password\n";
    }
}