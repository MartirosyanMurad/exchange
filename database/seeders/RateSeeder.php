<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $rates = json_decode(file_get_contents('https://blockchain.info/ticker'), true, 512, JSON_THROW_ON_ERROR);

        foreach ($rates as $name => $data) {
            DB::table('rates')->insert([
                'currency' => $name,
                'value' => $data['last'],
                'symbol' => $data['symbol'],
                'commission' => 2,
            ]);
        }

    }
}
