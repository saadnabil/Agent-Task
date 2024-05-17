<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CreatePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $permissions = [
            'agent-list',
            'agent-show',
            'agent-add',
            'agent-edit',
            'agent-delete',

            'feature-list',
            'feature-show',
            'feature-add',
            'feature-edit',
            'feature-delete',
            'feature-approve',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                [
                    'name' => $permission,
                    'guard_name' => 'api',
                ],
            );
        }
    }
}
