<?php

use Illuminate\Database\Seeder;

class AthletesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('athletes')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Johnny',
                'email' => 'johnny@gmail.com',
                'primary_number' => '914-433-8180',
                'secondary_number' => '231-1243-2324',
                'address' => '212 Somewhere Ave',
                'zipcode' => '10583',
                'city' => 'New York',
                'user_id' => 1,
                'created_at' => '2016-06-04 13:51:10',
                'updated_at' => '2016-06-04 13:51:10',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Jake',
                'email' => 'jake@gmail.com',
                'primary_number' => '114-433-8180',
                'secondary_number' => '333-1243-2324',
                'address' => '212 Somewhere Ave',
                'zipcode' => '10583',
                'city' => 'New York',
                'user_id' => 1,
                'created_at' => '2016-06-04 13:51:10',
                'updated_at' => '2016-06-04 13:51:10',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Dave',
                'email' => 'dave@gmail.com',
                'primary_number' => '912-433-8180',
                'secondary_number' => '531-1240-2324',
                'address' => '212 Somewhere Ave',
                'zipcode' => '10083',
                'city' => 'New York',
                'user_id' => 2,
                'created_at' => '2016-06-04 13:51:10',
                'updated_at' => '2016-06-04 13:51:10',
            ),
        ));
    }
}
