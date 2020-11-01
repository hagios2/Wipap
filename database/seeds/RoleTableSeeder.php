<?php

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
        $roles = ['super_amdin', 'admin'];

        foreach ($roles as $role)
        {
            Role::create(['role' => $role]);
        }

    }
}
