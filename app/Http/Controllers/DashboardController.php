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
        //Quickly Check If Invoices Have Been Paid
        // dd($this->send_daily_admin_report());

        // $recent_reservations = Reservations::where('reservation_status','confirmed')->where('company_id',Auth::user()->company->id)->orderBy('created_at','desc')->limit(16)->get();
        // $sevenday = Reservations::where('reservation_status','confirmed')->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-d 00:00:00',strtotime('-7 days')))->get();
        // $monthly = Reservations::where('reservation_status','confirmed')->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-01 00:00:00'))->get();
        // $count_sevenday = $sevenday->count();
        // $sum_sevenday = $sevenday->sum('grand_total');
        // $count_monthly = $monthly->count();
        // $sum_monthly = $monthly->sum('grand_total');

        $today = $this->mysqli_fetch("select sum(s.`grand_total`) as sum_grand_total, count(1) as count from reservations s where s.reservation_status = 'confirmed' and company_id = ".Auth::user()->company->id." and check_in = '".date('Y-m-d')."'");
        $status_counts = $this->mysqli_fetch_normal("select s.`reservation_status` as status, count(if(s.reservation_status='pending',if(s.created_by=0,1,NULL),1)) as count from reservations s where s.company_id = ".Auth::user()->company_id." and s.check_in >= '".date('Y-m-d')."' group by s.reservation_status");
        // dd($status_counts);

        $count_today = $today->count;
        $sum_today = $today->sum_grand_total;

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

        $limit = 1000;
        // $reservations = [];//$this->mysqli_fetch_normal("select `reservations`.*, `guests`.`full_name`, `rooms`.`name` as `roomname` from `reservations` inner join `guests` on `reservations`.`guest_id` = `guests`.`id` left join `rooms` on `reservations`.`room_id` = `rooms`.`id` where `reservations`.`company_id` = ".auth()->user()->company->id." and `reservations`.`check_in` > '".date("Y-m-d", strtotime('-30 days'))."' order by `reservations`.`check_in` asc limit ".$limit."");

        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->leftJoin('rooms','reservation_details.room_id','=','rooms.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in','>',date("Y-m-d", strtotime('-30 days')))->orderBy('reservations.check_in','asc')->limit($limit)->get();

        $callendar_reservation_list = [];
        // dd($reservations);

        foreach ($reservations as $key => $reservation) {
            if($reservation->reservation_status == "pending"){
                if(strtotime($reservation->check_in) < strtotime(date("Y-m-d"))){
                    $color = ['color' => '#FF0000','textColor' => '#fff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
                }else{
                    $color = ['color' => '#f3b760','textColor' => '#FF0000','url' => (auth()->user()->can('respond to reservation requests') ? ($reservation->created_by==0 ? route('reservations-view-request',$reservation->id) : route('reservations-show',$reservation->id)) : route('reservations-show',$reservation->id))];
                }
            }else if($reservation->payment_method == "complementary"){
                $color = ['color' => '#20368b;','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }else if($reservation->reservation_status == "confirmed" && $reservation->paid == "part"){
                $color = ['color' => '#fffb00','textColor' => '#46c37b','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }else if($reservation->reservation_status == "confirmed" && $reservation->paid == "full"){
                $color = ['color' => '#46c37b','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }else{
                $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }
            $callendar_reservation_list[] = Calendar::event(
                (($reservation->reservation_status == "pending" && $reservation->created_by==0) ? (strtotime($reservation->check_in) < strtotime(date("Y-m-d")) ? 'Expired Reservation Request: ' : 'Reservation Request: ') :'Reservation: ').'Room - '.($reservation->roomname ?? 'Unassigned Room Number').' ('.$reservation->full_name.')',
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
