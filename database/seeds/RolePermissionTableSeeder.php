<?php

use Illuminate\Database\Seeder;
use App\Models\PermissionRole;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * ADMIN ROLES
         *
         */
        $admin_role_ids = array('1','4');
        foreach($admin_role_ids as $admin_role_id) {
            $createUser = new PermissionRole;
            $createUser->role_id = $admin_role_id;
            $createUser->permission_id = '1';
            $createUser->timestamps = false;
            $createUser->save();

            $updateUser = new PermissionRole;
            $updateUser->role_id = $admin_role_id;
            $updateUser->permission_id = '2';
            $updateUser->timestamps = false;
            $updateUser->save();

            $deleteUser = new PermissionRole;
            $deleteUser->role_id = $admin_role_id;
            $deleteUser->permission_id = '3';
            $deleteUser->timestamps = false;
            $deleteUser->save();

            $createAthlete = new PermissionRole;
            $createAthlete->role_id = $admin_role_id;
            $createAthlete->permission_id = '4';
            $createAthlete->timestamps = false;
            $createAthlete->save();

            $updateAthlete = new PermissionRole;
            $updateAthlete->role_id = $admin_role_id;
            $updateAthlete->permission_id = '5';
            $updateAthlete->timestamps = false;
            $updateAthlete->save();

            $deleteAthlete = new PermissionRole;
            $deleteAthlete->role_id = $admin_role_id;
            $deleteAthlete->permission_id = '6';
            $deleteAthlete->timestamps = false;
            $deleteAthlete->save();

            $createTask = new PermissionRole;
            $createTask->role_id = $admin_role_id;
            $createTask->permission_id = '7';
            $createTask->timestamps = false;
            $createTask->save();

            $updateTask = new PermissionRole;
            $updateTask->role_id = $admin_role_id;
            $updateTask->permission_id = '8';
            $updateTask->timestamps = false;
            $updateTask->save();

            $createRecruit = new PermissionRole;
            $createRecruit->role_id = $admin_role_id;
            $createRecruit->permission_id = '9';
            $createRecruit->timestamps = false;
            $createRecruit->save();

            $updateRecruit = new PermissionRole;
            $updateRecruit->role_id = $admin_role_id;
            $updateRecruit->permission_id = '10';
            $updateRecruit->timestamps = false;
            $updateRecruit->save();
        }
    }
}
