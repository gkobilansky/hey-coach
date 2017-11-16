<?php

use Illuminate\Database\Seeder;
use App\Models\Permissions;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * User Permissions
         */
        
        $createUser = new Permissions;
        $createUser->display_name = 'Create user';
        $createUser->name = 'user-create';
        $createUser->description = 'Permission to create user';
        $createUser->save();

        $updateUser = new Permissions;
        $updateUser->display_name = 'Update user';
        $updateUser->name = 'user-update';
        $updateUser->description = 'Permission to update user';
        $updateUser->save();

        $deleteUser = new Permissions;
        $deleteUser->display_name = 'Delete user';
        $deleteUser->name = 'user-delete';
        $deleteUser->description = 'Permission to update delete';
        $deleteUser->save();


         /**
         * Athlete Permissions
         */
        
        $createAthlete = new Permissions;
        $createAthlete->display_name = 'Create athlete';
        $createAthlete->name = 'athlete-create';
        $createAthlete->description = 'Permission to create athlete';
        $createAthlete->save();

        $updateAthlete = new Permissions;
        $updateAthlete->display_name = 'Update athlete';
        $updateAthlete->name = 'athlete-update';
        $updateAthlete->description = 'Permission to update athlete';
        $updateAthlete->save();

        $deleteAthlete = new Permissions;
        $deleteAthlete->display_name = 'Delete athlete';
        $deleteAthlete->name = 'athlete-delete';
        $deleteAthlete->description = 'Permission to delete athlete';
        $deleteAthlete->save();

         /**
         * Tasks Permissions
         */
        
        $createTask = new Permissions;
        $createTask->display_name = 'Create task';
        $createTask->name = 'task-create';
        $createTask->description = 'Permission to create task';
        $createTask->save();

        $updateTask = new Permissions;
        $updateTask->display_name = 'Update task';
        $updateTask->name = 'task-update';
        $updateTask->description = 'Permission to update task';
        $updateTask->save();

         /**
         * Recruits Permissions
         */
        
        $createRecruit = new Permissions;
        $createRecruit->display_name = 'Create recruit';
        $createRecruit->name = 'recruit-create';
        $createRecruit->description = 'Permission to create recruit';
        $createRecruit->save();

        $updateRecruit = new Permissions;
        $updateRecruit->display_name = 'Update recruit';
        $updateRecruit->name = 'recruit-update';
        $updateRecruit->description = 'Permission to update recruit';
        $updateRecruit->save();
    }
}
