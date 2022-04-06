<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $admin = Role::create(['name' => 'administrator']);
        $editor = Role::create(['name' => 'editor']);
        $author = Role::create(['name' => 'author']);

        $permission = Permission::create(['name' => 'view guests']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'add guests']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'edit guests']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'remove guests']);
        $permission->assignRole($admin);

        $permission = Permission::create(['name' => 'view rooms']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'add rooms']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'edit rooms']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'remove rooms']);
        $permission->assignRole($admin);

        $permission = Permission::create(['name' => 'view roomtypes']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'add roomtypes']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'edit roomtypes']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'remove roomtypes']);
        $permission->assignRole($admin);

        $permission = Permission::create(['name' => 'view users']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'add users']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'edit users']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'remove users']);
        $permission->assignRole($admin);

        $permission = Permission::create(['name' => 'view settings']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'edit company']);
        $permission->assignRole($admin);

        $permission = Permission::create(['name' => 'view reservation']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'add reservation']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'respond to reservation requests']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);
        $permission->assignRole($author);

        $permission = Permission::create(['name' => 'edit reservation']);
        $permission->assignRole($admin);
        $permission->assignRole($editor);

        $permission = Permission::create(['name' => 'remove reservation']);
        $permission->assignRole($admin);

        $user = User::find(1);
        $user->assignRole('administrator');
    }
}
