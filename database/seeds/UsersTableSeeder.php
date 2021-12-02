<?php

use App\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $gender = ['male','female'];
        $lat = [26.0111,26.0211,26.0311,26.0411,26.0511,26.0611];
        $faker = Faker::create();
        foreach(range(1,3) as $val){
            $userRecords = [
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('admin'),
                'date_of_birth' =>$faker->date('Y-m-d','now'),
                'gender' => $faker->randomElement($gender),
                'location' => $faker->address,
                'latitude'=> $faker->randomElement($lat),
                'longitude'=> 88.4693,
            ];
            User::insert($userRecords);
        }
    }
}
