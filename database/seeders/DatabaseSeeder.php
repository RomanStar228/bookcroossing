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
       
        $this->call(CitySeeder::class);

       
        $this->call(GenreSeeder::class);

        
        $admin = User::updateOrCreate(
            ['email' => 'admin@bookcrosser.ru'],
            [
                'username'    => 'admin',
                'full_name'   => 'Администратор',
                'password'    => bcrypt('123456789'),   
                'city_id'     => City::first()->id ?? 1,
                'role'        => 'admin',
                'is_banned'   => false,
                'rating'      => 5.00,
                'description' => 'Главный администратор платформы BookCrosser',
            ]
        );

        

        
        User::updateOrCreate(
            ['email' => 'test@bookcrosser.ru'],
            [
                'username'    => 'testuser',
                'full_name'   => 'Тестовый Пользователь',
                'password'    => bcrypt('password'),
                'city_id'     => City::first()->id ?? 1,
                'role'        => 'user',
                'is_banned'   => false,
                'rating'      => 0.00,
            ]
        );

       
    }
}