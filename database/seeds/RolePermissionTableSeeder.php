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
        $createUser = new PermissionRole;
        $createUser->role_id = '1';
        $createUser->permission_id = '1';
        $createUser->timestamps = false;
        $createUser->save();

        $updateUser = new PermissionRole;
        $updateUser->role_id = '1';
        $updateUser->permission_id = '2';
        $updateUser->timestamps = false;
        $updateUser->save();

        $deleteUser = new PermissionRole;
        $deleteUser->role_id = '1';
        $deleteUser->permission_id = '3';
        $deleteUser->timestamps = false;
        $deleteUser->save();

        $createAthlete = new PermissionRole;
        $createAthlete->role_id = '1';
        $createAthlete->permission_id = '4';
        $createAthlete->timestamps = false;
        $createAthlete->save();

        $updateAthlete = new PermissionRole;
        $updateAthlete->role_id = '1';
        $updateAthlete->permission_id = '5';
        $updateAthlete->timestamps = false;
        $updateAthlete->save();

        $deleteAthlete = new PermissionRole;
        $deleteAthlete->role_id = '1';
        $deleteAthlete->permission_id = '6';
        $deleteAthlete->timestamps = false;
        $deleteAthlete->save();

        $createTask = new PermissionRole;
        $createTask->role_id = '1';
        $createTask->permission_id = '7';
        $createTask->timestamps = false;
        $createTask->save();

        $updateTask = new PermissionRole;
        $updateTask->role_id = '1';
        $updateTask->permission_id = '8';
        $updateTask->timestamps = false;
        $updateTask->save();

        $createRecruit = new PermissionRole;
        $createRecruit->role_id = '1';
        $createRecruit->permission_id = '9';
        $createRecruit->timestamps = false;
        $createRecruit->save();

        $updateRecruit = new PermissionRole;
        $updateRecruit->role_id = '1';
        $updateRecruit->permission_id = '10';
        $updateRecruit->timestamps = false;
        $updateRecruit->save();
    }
}
