<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	User::create([
	        'name' => 'Cesar',
	    	'email' => 'cesar_altuve@hotmail.com',
	        'password' => bcrypt('123123'),
            'admin' => true
            'phone' => '04147330834',
            'address' => 'los proceres',
            'username' => 'cesaraltuve',

    	]);

    }
}
