<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin123'),
                'college_id' => 1,
                'address' => '',
                'work_number' => 0,
                'personal_number' => 0,
                'image_path' => '',
                'college_id' => 1,
                'remember_token' => null,
                'created_at' => '2016-06-04 13:42:19',
                'updated_at' => '2016-06-04 13:42:19',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Admin2',
                'email' => 'admin2@admin.com',
                'password' => bcrypt('admin1234'),
                'address' => '',
                'work_number' => 0,
                'personal_number' => 0,
                'image_path' => '',
                'college_id' => 2,
                'remember_token' => null,
                'created_at' => '2016-06-04 13:42:19',
                'updated_at' => '2016-06-04 13:42:19',
            ),            
        ));
    }
}
