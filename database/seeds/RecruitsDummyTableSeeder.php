<?php

use Illuminate\Database\Seeder;

class RecruitsDummyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Recruit::class, 30)->create()->each(function ($c) {
            $c->athletes()->save(factory(App\Model\Athlete::class)->make());
            $c->users()->save(factory(App\Model\User::class)->make());
        });
    }
}
