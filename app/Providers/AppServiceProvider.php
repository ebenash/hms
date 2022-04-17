<?php

namespace App\Providers;

use Calendar;
use App\Models\Auth;
use App\Models\User;
use App\Models\UserRoles;
use App\Models\Company;
use App\Models\RoomTypes;
use App\Models\AccessLevels;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\Reservations;
use App\Models\HotelNotifications;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
// use MaddHatter\LaravelFullcalendar\Calendar;

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
        Paginator::useBootstrap();


        view()->composer('*', function($view) {
            if(auth()->user()){
                $view->with('current_user', auth()->user());
                $view->with('all_roles', UserRoles::all());
                // $view->with('all_companies', Company::all());
                // $view->with('all_guests', Guests::where('company_id',auth()->user()->company->id)->get());
                $view->with('all_accesslevels', AccessLevels::all());
                $view->with('notifications', HotelNotifications::where('status','unread')->get());
            }
            // }else{
            //     $view->with('current_user', -1);
            //     $view->with('all_users', User::all());
            //     $view->with('all_roles', UserRoles::all());
            //     $view->with('all_companies', Company::all());
            //     $view->with('all_roomtypes', RoomTypes::all());
            //     $view->with('all_guests', Guests::all());
            //     $view->with('all_rooms', Rooms::all());
            //     $view->with('all_reservations', Reservations::all());
            //     $view->with('all_accesslevels', AccessLevels::all());
            // }
            $view->with('main_company', Company::find(1));
        });
    }
}

