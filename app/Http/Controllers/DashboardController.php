<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Acaronlex\LaravelCalendar\Calendar;

class DashboardController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $recent_reservations = Reservations::where('reservation_status','confirmed')->where('company_id',Auth::user()->company->id)->orderBy('created_at','desc')->limit(16)->get();
        // $sevenday = Reservations::where('reservation_status','confirmed')->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-d 00:00:00',strtotime('-7 days')))->get();
        // $monthly = Reservations::where('reservation_status','confirmed')->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-01 00:00:00'))->get();
        // $count_sevenday = $sevenday->count();
        // $sum_sevenday = $sevenday->sum('price');
        // $count_monthly = $monthly->count();
        // $sum_monthly = $monthly->sum('price');

        $today = $this->mysqli_fetch("select sum(s.`price`) as sum_price, count(1) as count from reservations s where s.reservation_status = 'confirmed' and company_id = ".Auth::user()->company->id." and check_in = '".date('Y-m-d')."'");
        $status_counts = $this->mysqli_fetch_normal("select s.`reservation_status` as status, count(1) as count from reservations s where s.company_id = ".Auth::user()->company_id." and s.check_in >= '".date('Y-m-d')."' group by s.reservation_status");
        // dd($status_counts);

        $count_today = $today->count;
        $sum_today = $today->sum_price;

        $requestscount = 0;
        $confirmedcount = 0;
        $cancelledcount = 0;

        foreach($status_counts as $each){
            if($each->status == 'pending'){
                $requestscount = $each->count;
            }else if($each->status == 'confirmed'){
                $confirmedcount = $each->count;
            }else if($each->status == 'cancelled'){
                $cancelledcount = $each->count;
            }
        }

        $reservations = Reservations::where('company_id',auth()->user()->company->id)->where('check_in','>',date("Y-m-d", strtotime('-30 days')))->get();
        $callendar_reservation_list = [];

        foreach ($reservations as $key => $reservation) {
            if($reservation->reservation_status == "pending"){
                if(strtotime($reservation->check_in) < strtotime(date("Y-m-d"))){
                    $color = ['color' => '#FF0000','textColor' => '#fff','url' => route('reservations-show',$reservation->id)];
                }else{
                    $color = ['color' => '#f3b760','textColor' => '#FF0000','url' => route('reservations-view-request',$reservation->id)];
                }
            }else if($reservation->reservation_status == "confirmed"){
                $color = ['color' => '#46c37b','textColor' => '#ffffff','url' => route('reservations-show',$reservation->id)];
            }else{
                $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => route('reservations-show',$reservation->id)];
            }
            $callendar_reservation_list[] = Calendar::event(
                ($reservation->reservation_status == "pending" ? (strtotime($reservation->check_in) < strtotime(date("Y-m-d")) ? 'Expired Reservation Request: ' : 'Reservation Request: ') :'Reservation: ').$reservation->roomtype->name.' - '.($reservation->room->name ?? 'Unassigned Room Number').' ('.$reservation->guest->full_name.')',
                true,
                new \DateTime($reservation->check_in),
                new \DateTime($reservation->check_out.' +1 day'),
                $reservation->id,
                $color
            );
        }

        $reservations_data = [
            // 'recent_reservations' => $recent_reservations,
            // 'today'=> $today,
            // // 'sevenday' => $sevenday,
            // // 'monthly' => $monthly,
            // 'sum_today' => $sum_today,
            // 'count_sevenday' => $count_sevenday,
            // 'sum_sevenday' => $sum_sevenday,

            // 'sum_monthly' => $sum_monthly,
            // 'count_monthly' => $count_monthly,

            'count_today' => $count_today,
            'count_requests' => $requestscount,
            'count_confirmed' => $confirmedcount,
            'count_cancelled' => $cancelledcount,
            'helper' => new Helper(),
            'callendar_reservation_list' => $callendar_reservation_list
        ];
        // dd($reservations_data);

        return view('dashboard',$reservations_data);
    }
}
