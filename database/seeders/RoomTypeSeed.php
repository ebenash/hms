<?php

use Illuminate\Database\Seeder;
use App\Models\RoomTypes;

class RoomTypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
