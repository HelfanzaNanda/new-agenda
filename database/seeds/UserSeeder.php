<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$user1 = User::create([
			'name' => 'Super Admin',
			'email' => 'superadmin@gmail.com',
			'password' => Hash::make('password')
		]);

		$user1->assignRole('super admin');

		$user2 = User::create([
			'name' => 'admin',
			'email' => 'admin@gmail.com',
			'password' => Hash::make('password')
		]);

		$user2->assignRole('admin');
    }
}
