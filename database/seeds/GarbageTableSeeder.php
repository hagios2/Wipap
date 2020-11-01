<?php

use App\Bin;
use Illuminate\Database\Seeder;

class GarbageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bins = ['organic', 'metals', 'plastic', 'poly-ethene'];

        foreach ($bins as $bin)
        {
            Bin::create(['bin_type' => $bin]);

        }
    }
}
