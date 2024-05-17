<?php

namespace Database\Seeders;

use App\Models\Agent;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateAgent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $country = Country::firstOrCreate([
            'country' => 'Egypt',
            'timezone' => 'Africa/Cairo'
        ]);
        for($i = 0 ; $i < 500  ; $i ++ ){
            Agent::create([
                'firstname' =>  fake()->firstName(),
                'lastname' =>  fake()->lastName(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'country_id' =>  $country->id,
                'balance' => rand(0,1000),
                'role' =>  fake()->words(5, true),
                'birthdate' => Carbon::now()
            ]);
        }

    }
}
