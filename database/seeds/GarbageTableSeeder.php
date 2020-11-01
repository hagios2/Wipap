<?php

use App\GarbageType;
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
        $garbages = ['organic', 'metals', 'plastic', 'poly-ethene'];

        foreach ($garbages as $garbage)
        {
            GarbageType::create(['garbage_type' => $garbage]);

        }
    }
}
