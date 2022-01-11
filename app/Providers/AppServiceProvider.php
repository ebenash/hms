<?php

namespace App\Providers;

// use Calendar;
use App\Models\Auth;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Company;
use App\Models\RoomTypes;
use App\Models\AccessLevels;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\Reservations;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use MaddHatter\LaravelFullcalendar\Calendar;

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


        view()->composer('*', function($view) {
            if(auth()->user()){
                $view->with('current_user', auth()->user());
                $view->with('all_users', User::where('company_id',auth()->user()->company->id)->get());
                $view->with('all_roles', UserRoles::all());
                $view->with('all_companies', Company::all());
                $view->with('all_roomtypes', RoomTypes::where('company_id',auth()->user()->company->id)->get());
                $view->with('all_guests', Guests::where('company_id',auth()->user()->company->id)->get());
                $view->with('all_rooms', Rooms::orderBy('name','asc')->where('company_id',auth()->user()->company->id)->get());
                $view->with('all_reservations', Reservations::orderBy('created_at','desc')->where('company_id',auth()->user()->company->id)->get());
                $view->with('all_accesslevels', AccessLevels::all());

                $reservations = Reservations::where('company_id',auth()->user()->company->id)->get();
                $callendar_reservation_list = [];
                foreach ($reservations as $key => $reservation) {
                    if($reservation->reservation_status == "0"){
                        $color = ['color' => '#f3b760','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
                    }else if($reservation->reservation_status == "1"){
                        $color = ['color' => '#46c37b','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
                    }else{
                        $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => '/reservations/'.$reservation->id];
                    }
                    $callendar_reservation_list[] = Calendar::event(
                        'Reservation: '.$reservation->room->name.' - ('.$reservation->guest->first_name.' '.$reservation->guest->last_name.')',
                        true,
                        new \DateTime($reservation->check_in),
                        new \DateTime($reservation->check_out.' +1 day'),
                        $reservation->id,
                        $color
                    );
                }
                $view->with('callendar_reservation_list', $callendar_reservation_list);
            }else{
                $view->with('current_user', -1);
                $view->with('all_users', User::all());
                $view->with('all_roles', UserRoles::all());
                $view->with('all_companies', Company::all());
                $view->with('all_roomtypes', RoomTypes::all());
                $view->with('all_guests', Guests::all());
                $view->with('all_rooms', Rooms::all());
                $view->with('all_reservations', Reservations::all());
                $view->with('all_accesslevels', AccessLevels::all());
                $view->with('callendar_reservation_list', -1);
            }
        });
    }
}

