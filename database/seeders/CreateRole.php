<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleName  =  'Developer';

        $role = Role::Create(['name' =>$roleName, 'guard_name' => 'api' ]);

        $permissions = Permission::pluck('name')->toarray();

        $role->syncPermissions($permissions);

        return $this->sendResponse([]);
    }
}
