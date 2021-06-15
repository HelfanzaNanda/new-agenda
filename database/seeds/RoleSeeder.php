<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
			'super admin', 'admin', 'sekretaris', 'deputi(Eselon I)', 'asdep/karo(eselon II)', 'eselon III'
		];

		foreach($roles as $role){
			Role::create([
				'name' => $role
			]);
		}
    }
}
