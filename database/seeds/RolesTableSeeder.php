<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $adminRole = new Role;
        $adminRole->display_name = 'Administrator';
        $adminRole->name = 'administrator';
        $adminRole->description = 'System Administrator';
        $adminRole->save();

        $editorRole = new Role;
        $editorRole->display_name = 'Head Coach';
        $editorRole->name = 'coach';
        $editorRole->description = 'head coach';
        $editorRole->save();

        $employeeRole = new Role;
        $employeeRole->display_name = 'Assistant Coach';
        $employeeRole->name = 'assistant';
        $employeeRole->description = 'assistant';
        $employeeRole->save();

        $employeeRole = new Role;
        $employeeRole->display_name = 'Super Administrator';
        $employeeRole->name = 'super_administrator';
        $employeeRole->description = 'System Administrator';
        $employeeRole->save();        
    }
}
