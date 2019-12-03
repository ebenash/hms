<?php

namespace App\Providers;

use Calendar;
use App\Auth;
use App\User;
use App\UserRoles;
use App\Company;
use App\RoomTypes;
use App\AccessLevels;
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
        

        view()->composer('*', function($view) {
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
        }); 
    }
}

