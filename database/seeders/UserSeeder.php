<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $Admin = [
            [
                'name'=>'Dr. Amber',
                'email'=>'doctor@amber.health',
                'password'=>bcrypt('headdoctor'),
                'role'=>'doctor',
                'status'=>'Doctor'
            ],
        ];

        foreach( $Admin as $key => $value){
            User::create($value);
        }
    }
}
