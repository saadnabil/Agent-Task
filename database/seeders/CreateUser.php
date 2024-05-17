<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUser extends Seeder
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
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'phone' => '+201143707240',
            'gender' => 'male',
            'country_id' =>  $country->id,
            'password' => bcrypt('12345678'),
        ]);
    }
}
