<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
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

        $limit = 10000;
        // $reservations = [];//$this->mysqli_fetch_normal("select `reservations`.*, `guests`.`full_name`, `rooms`.`name` as `roomname` from `reservations` inner join `guests` on `reservations`.`guest_id` = `guests`.`id` left join `rooms` on `reservations`.`room_id` = `rooms`.`id` where `reservations`.`company_id` = ".auth()->user()->company->id." and `reservations`.`check_in` > '".date("Y-m-d", strtotime('-30 days'))."' order by `reservations`.`check_in` asc limit ".$limit."");

        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in','>',date("Y-m-d", strtotime('-30 days')))->orderBy('reservations.check_in','asc')->limit($limit)->get();

        $callendar_reservation_list = [];
        // dd($reservations);

        foreach ($reservations as $key => $reservation) {
            if($reservation->reservation_status == "pending"){
                if(strtotime($reservation->check_in) < strtotime(date("Y-m-d"))){
                    $color = ['color' => '#FF0000','textColor' => '#fff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
                }else{
                    $color = ['color' => '#f3b760','textColor' => '#FF0000','url' => (auth()->user()->can('respond to reservation requests') ? route('reservations-view-request',$reservation->id) : route('reservations-show',$reservation->id))];
                }
            }else if($reservation->reservation_status == "confirmed"){
                $color = ['color' => '#46c37b','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }else{
                $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }
            $callendar_reservation_list[] = Calendar::event(
                ($reservation->reservation_status == "pending" ? (strtotime($reservation->check_in) < strtotime(date("Y-m-d")) ? 'Expired Reservation Request: ' : 'Reservation Request: ') :'Reservation: ').'Room - '.($reservation->roomname ?? 'Unassigned Room Number').' ('.$reservation->full_name.')',
                true,
                new \DateTime($reservation->check_in),
                new \DateTime($reservation->check_out.' +1 day'),
                $reservation->id,
                $color
            );
        }

        $reservations_data = [
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
