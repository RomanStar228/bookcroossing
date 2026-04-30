<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE books CHANGE status status ENUM('Отдаю', 'Ищу', 'Забронирована', 'Обменяна', 'Можно забирать') NOT NULL DEFAULT 'Отдаю'");
    }

    public function down()
    {
        DB::statement("ALTER TABLE books CHANGE status status ENUM('Отдаю', 'Ищу', 'Забронирована', 'Обменяна') NOT NULL DEFAULT 'Отдаю'");
    }
};