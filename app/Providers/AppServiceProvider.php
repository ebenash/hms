<?php

namespace App\Providers;

use Calendar;
use App\RoomTypes;
use App\Guests;
use App\Rooms;
use App\Reservations;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    public function boot()
    {
        Schema::defaultStringLength(191);
        view()->share('all_roomtypes', RoomTypes::all());
        view()->share('all_guests', Guests::all());
        view()->share('all_rooms', Rooms::all());
        view()->share('all_reservations', Reservations::all());

        $reservations = Reservations::all();
    	$reservation_list = [];
    	foreach ($reservations as $key => $reservation) {
            if($reservation->reservation_status == "0"){
                $color = ['color' => '#f3b760','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
            }else if($reservation->reservation_status == "1"){
                $color = ['color' => '#46c37b','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
            }else{
                $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
            }
    		$reservation_list[] = Calendar::event(
                'Reservation: '.$reservation->room->name,
                true,
                new \DateTime($reservation->check_in),
                new \DateTime($reservation->check_out.' +1 day'),
                $reservation->id,
                $color
            );
    	}
        $all_calendar_reservations = Calendar::addEvents($reservation_list); 
        
        view()->share('all_calendar_reservations', $all_calendar_reservations);

    }
}

