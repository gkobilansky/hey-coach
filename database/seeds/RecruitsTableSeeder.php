<?php

use Illuminate\Database\Seeder;

class RecruitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        
        
        \DB::table('recruits')->insert(array (
            0 =>
            array (
                'id' => 1,
                'title' => 'Loves NYU',
                'description' => 'Tell this new kid about family at NYU',
                'status_id' => 1,
                'user_assign_id' => 1,
                'athlete_id' => 9,
                'user_created_id' => 1,
                'contact_date' => '2016-06-18 12:00:00',
                'created_at' => '2016-06-04 13:51:10',
                'updated_at' => '2016-06-04 13:51:10',
            ),
            1 =>
            array (
                'id' => 2,
                'title' => 'Interested in ED1',
                'description' => 'Give them a call about the new items',
                'status_id' => 1,
                'user_assign_id' => 1,
                'athlete_id' => 10,
                'user_created_id' => 1,
                'contact_date' => '2016-06-18 13:00:00',
                'created_at' => '2016-06-04 13:56:27',
                'updated_at' => '2016-06-04 13:56:27',
            ),
            2 =>
            array (
                'id' => 3,
                'title' => 'Athlete wants to know more about item',
                'description' => '',
                'status' => 2,
                'user_assign_id' => 1,
                'athlete_id' => 10,
                'user_created_id' => 1,
                'contact_date' => '2016-06-14 12:00:00',
                'created_at' => '2016-06-04 13:57:07',
                'updated_at' => '2016-06-04 13:57:07',
            ),
        ));
    }
}
