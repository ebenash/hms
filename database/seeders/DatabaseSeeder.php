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
        Company::factory(1)->create();
        User::factory(1)->create();

        $exists = RoomTypes::all();

        if($exists->count() == 0){
            RoomTypes::insert([
                [
                    'name' => 'Standard Room',
                    'price_from' => 400,
                    'max_persons' => 2,
                    'bed_type' => '1 Queen Bed OR 2 Twin Beds',
                    'category' => 'room',
                    'size' => '40',
                    'description' => 'Amenities available: private balcony, refrigerator, wall-mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free WiFi, sun blocker curtains, bath tub.',
                    'image_one' => 'homepage/assets/img/reh/MG_8301.jpg',
                    'image_two' => '',
                    'image_three' => '',
                ],[
                    'name' => 'Standard Double Occupancy',
                    'price_from' => 450,
                    'max_persons' => 2,
                    'bed_type' => '2 Twin Beds',
                    'category' => 'room',
                    'size' => '50',
                    'description' => 'Amenities available: private balcony, refrigerator, wall-mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free WiFi, sun blocker curtains.',
                    'image_one' => 'homepage/assets/img/reh/MG_8179.jpg',
                    'image_two' => null,
                    'image_three' => null,
                ],[
                    'name' => 'Junior Deluxe Room',
                    'price_from' => 550,
                    'max_persons' => 2,
                    'bed_type' => '1 Queen Bed',
                    'category' => 'room',
                    'size' => '80',
                    'description' => 'Amenities: fully-carpeted space, dining table (with four chairs), three-seater sofa, private balcony, refrigerator, wall-mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free WiFi, sun blocker curtains.',
                    'image_one' => 'homepage/assets/img/reh/MG_8417.jpg',
                    'image_two' => null,
                    'image_three' => null,
                ],[
                    'name' => 'Superior Deluxe Room',
                    'price_from' => 700,
                    'max_persons' => 4,
                    'bed_type' => '2 Full-sized Beds',
                    'category' => 'room',
                    'size' => '90',
                    'description' => 'Amenities: armchair recliner, private balcony, refrigerator, wall-mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free wi-fi, sun blocker curtains.',
                    'image_one' => 'homepage/assets/img/reh/MG_8444.jpg',
                    'image_two' => null,
                    'image_three' => null,
                ],[
                    'name' => 'Family Unit',
                    'price_from' => 1200,
                    'max_persons' => 4,
                    'bed_type' => '1 Queen Bed and 2 Twin Beds',
                    'category' => 'suite',
                    'size' => '150',
                    'description' => 'Living Area: Three-seater, two-seater, and armchair Leather Sofa Recliners, marble dining table (with 4 chairs), mini bar. <br/><br/>Amenities: dining table (with four chairs), private balcony, refrigerator, wall- mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free wi-fi, sun blocker curtains.',
                    'image_one' => 'homepage/assets/img/reh/MG_8244.jpg',
                    'image_two' => 'homepage/assets/img/reh/MG_8556.jpg',
                    'image_three' => 'homepage/assets/img/reh/MG_8253.jpg',
                ],[
                    'name' => 'Executive Suite',
                    'price_from' => 1000,
                    'max_persons' => 2,
                    'bed_type' => '1 King Bed',
                    'category' => 'suite',
                    'size' => '140',
                    'description' => 'Spacious Living Area: Three-seater, two-seater, and armchair Leather Sofa Recliners, marble dining table (with 4 chairs), mini bar. <br/><br/>Amenities: Guest toilet, Hairdryer, Jacuzzi, Shower, private balcony, refrigerator, wall-mounted safe, hot water shower, air conditioner, work desk, leather recliner, flat-screen television with multiple channels, free wi-fi, sun blocker curtains.',
                    'image_one' => 'homepage/assets/img/reh/MG_8573.jpg',
                    'image_two' => 'homepage/assets/img/reh/DSC1711.jpg',
                    'image_three' => 'homepage/assets/img/reh/MG_8586.jpg',
                ]
            ]);
        }

        // Guests::factory(20000)->create();
        // Rooms::factory(1000)->create();
        // RoomTypes::factory(500)->create();
        // Reservations::factory(20000)->create();

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
