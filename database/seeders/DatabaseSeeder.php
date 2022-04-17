<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Guests;
use App\Models\Reservations;
use App\Models\Rooms;
use App\Models\RoomTypes;
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
        // Company::factory(1)->create();
        // User::factory(1)->create();
        // Guests::factory(20000)->create();
        // Rooms::factory(1000)->create();
        // RoomTypes::factory(500)->create();
        Reservations::factory(20000)->create();

        $admin = Role::findOrCreate('administrator');
        $editor = Role::findOrCreate('editor');
        $user = Role::findOrCreate('user');
        $auditor = Role::findOrCreate('auditor');

        $permission = Permission::findOrCreate('view guests');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);
        // $permission->assignRole($user);

        $permission = Permission::findOrCreate('add guests');
        $permission->syncRoles([$admin,$editor,$user]);

        $permission = Permission::findOrCreate('edit guests');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('remove guests');
        $permission->syncRoles([$admin]);

        $permission = Permission::findOrCreate('view rooms');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);

        $permission = Permission::findOrCreate('add rooms');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('edit rooms');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('remove rooms');
        $permission->syncRoles([$admin]);

        $permission = Permission::findOrCreate('view roomtypes');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);

        $permission = Permission::findOrCreate('add roomtypes');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('edit roomtypes');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('remove roomtypes');
        $permission->syncRoles([$admin]);

        $permission = Permission::findOrCreate('view users');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);

        $permission = Permission::findOrCreate('add users');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('edit users');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('remove users');
        $permission->syncRoles([$admin]);

        $permission = Permission::findOrCreate('view settings');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);

        $permission = Permission::findOrCreate('edit company');
        $permission->syncRoles([$admin]);

        $permission = Permission::findOrCreate('view reservations');
        $permission->syncRoles([$admin,$editor,$user,$auditor]);

        $permission = Permission::findOrCreate('add reservations');
        $permission->syncRoles([$admin,$editor,$user]);

        $permission = Permission::findOrCreate('respond to reservation requests');
        $permission->syncRoles([$admin,$editor,$user]);

        $permission = Permission::findOrCreate('edit reservations');
        $permission->syncRoles([$admin,$editor]);

        $permission = Permission::findOrCreate('remove reservations');
        $permission->syncRoles([$admin]);

        $user = User::find(1);
        $user->syncRoles('administrator');
    }
}
