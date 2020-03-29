<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
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
        $user = new User;
        $user->name = 'Juan Dela Cruz';
        $user->email = 'jdc@gmail.com';
        $user->password = Hash::make('admin1234');
        $user->save();
        $user->roles()->attach(Role::where('name', 'Administrator')->first());
    }
}
