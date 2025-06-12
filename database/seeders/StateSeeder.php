<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['country_id'=>'1','name'=> 'Tamilnadu'],
            ['country_id'=> '1','name'=> 'Kerala'],
            ['country_id'=> '2','name'=> 'California'],
            ['country_id'=> '2','name'=> 'Texas'],
        ];
        foreach ($states as $state) {
            State::create($state);
        }
    }
}
