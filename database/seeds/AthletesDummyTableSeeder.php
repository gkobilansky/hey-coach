<?php

use Illuminate\Database\Seeder;

class AthletesDummyTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
         factory(App\Models\Athlete::class, 50)->create()->each(function ($c) {
         });
    }
}
