<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = new Role;
        $role->name = 'Administrator';
        $role->description = 'Super User';
        $role->save();

        $role = new Role;
        $role->name = 'User';
        $role->description = 'User only';
        $role->save();
    }
}
