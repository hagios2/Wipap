<?php

use Illuminate\Database\Seeder;
use App\Day;

class DayTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        foreach ($days as $day)
        {
            Day::create(['day' => $day]);
        }
    }
}
