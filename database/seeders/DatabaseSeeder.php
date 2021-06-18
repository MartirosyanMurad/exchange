<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i <= 30; $i++) {
            DB::table('users')->insert([
                'age' => random_int(3, 23),
                'name' => "name $i",
                'first_name' => "First $i",
                'last_name' => "Last $i",
                'email' => "email$i@mail.ru",
                'password' => md5('password'),
            ]);
        }

        for ($i = 0; $i <= 3; $i++) {
            for ($j = 0; $j <= 30; $j++) {
                DB::table('books')->insert([
                    'name' => "book_name_$j",
                    'author' => "author_$i",
                ]);
            }
        }

        $pairs = [];

        for ($i = 0; $i <= 300; $i++) {


            $uId = random_int(1, 31);
            $bId = random_int(1, 90);
            if (isset($pairs[$uId]) && in_array($bId, $pairs[$uId], true)) {
                continue;
            }

            $pairs[$uId][] = $bId;
        }

        foreach ($pairs as $userId => $bookIds) {
            foreach ($bookIds as $bookId) {
                DB::table('user_books')->insert([
                    'user_id' => $userId,
                    'book_id' => $bookId,
                ]);
            }
        }

        // Пользователь который удовлетворяет требованиям первого задания
        //  возраста от 7 и до 17 лет, которые взяли только 2 книги и все книги одного и того же автора
        DB::table('users')->insert([
            'age' => 14,
            'name' => 'name',
            'first_name' => 'Name',
            'last_name' => 'Last',
            'email' => 'test@mail.ru',
            'password' => md5('password'),
        ]);
        DB::table('user_books')->insert([
            'user_id' => 32,
            'book_id' => 1,
        ]);
        DB::table('user_books')->insert([
            'user_id' => 32,
            'book_id' => 2,
        ]);
    }
}
