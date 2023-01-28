<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spainCA = [
        'CAT' => 'Cataluna',
        'VAL' => 'Valencia',
        'MAD' => 'Madrid',
        'AND' => 'Andalucia',
        'CLM' => 'Castilla La Mancha',
        'MRC' => 'Murcia',
        'ARG' => 'Aragon'
        ];
        $countries = [
            ['code' => 'esp', 'name' => 'España', 'community' => json_encode($spainCA)],
            ['code' => 'fra', 'name' => 'Francia', 'community' => null],
            ['code' => 'por', 'name' => 'Portugal', 'community' => null],
            ['code' => 'ger', 'name' => 'Alemania', 'community' => null],
            ['code' => 'ger', 'name' => 'Andorra', 'community' => null],
            ['code' => 'ger', 'name' => 'Italia', 'community' => null],
        ];
        Country::insert($countries);
    }
}
