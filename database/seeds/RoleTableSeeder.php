<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $roles = ['super_admin', 'admin'];
//
//        foreach ($roles as $role)
//        {
//            Role::create(['role' => $role]);
//        }

        $d = \App\WasteCompany::find(1);

        $d->update(['published'=> true]);
    }
}
