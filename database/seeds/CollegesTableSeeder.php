<?php

use Illuminate\Database\Seeder;

class CollegesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('colleges')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'NYU',
                'sub_domain_name' => 'nyu',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Iowa University',
                'sub_domain_name' => 'iowa',
            ),
        ));
    }
}
