<?php

use App\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		
		factory(User::class, 5)->create();
		$this->call([
			RoleSeeder::class,
			UserSeeder::class
		]);

		$users = User::all();
		foreach($users as $user){
			if(!$user->hasRole(['super admin', 'admin'])){
				$user->update([
					'api_token' => Str::random(60)
				]);
			}
		}
    }
}
