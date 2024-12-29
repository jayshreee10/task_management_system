<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $teamMember = Role::firstOrCreate(['name' => 'Team Member']);


        $createTasks = Permission::firstOrCreate(['name' => 'create tasks']);
        $assignTasks = Permission::firstOrCreate(['name' => 'assign tasks']);
        $viewTasks = Permission::firstOrCreate(['name' => 'view tasks']);
        $editTasks = Permission::firstOrCreate(['name' => 'edit tasks']);
        $deleteTasks = Permission::firstOrCreate(['name' => 'delete tasks']);


        $admin->givePermissionTo([$createTasks, $assignTasks, $viewTasks, $editTasks, $deleteTasks]);
        $manager->givePermissionTo([$createTasks, $assignTasks, $viewTasks, $editTasks]);
        $teamMember->givePermissionTo([$viewTasks, $editTasks]);
    }
}
