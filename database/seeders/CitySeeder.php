<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            'Москва',
            'Санкт-Петербург',
            'Новосибирск',
            'Екатеринбург',
            'Челябинск',
            'Казань',
            'Нижний Новгород',
            'Красноярск',
            'Самара',
            'Уфа',
            'Ростов-на-Дону',
            'Омск',
            'Краснодар',
            'Воронеж',
            'Пермь',
            'Волгоград',
            'Тюмень',
            'Саратов',
            'Тольятти',
            'Ижевск',
        ];

        foreach ($cities as $cityName) {
            City::firstOrCreate(['name' => $cityName]);
        }

        echo "✅ Добавлено " . count($cities) . " городов\n";
    }
}