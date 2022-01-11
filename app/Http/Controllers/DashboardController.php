<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservations;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class DashboardController extends Controller
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
        $recent_reservations = Reservations::where('reservation_status',1)->where('company_id',Auth::user()->company->id)->orderBy('created_at','desc')->limit(16)->get();
        $today = Reservations::where('reservation_status',1)->where('company_id',Auth::user()->company->id)->orderBy('created_at','desc')->where('created_at', '>', date('Y-m-d 00:00:00'))->get();
        $sevenday = Reservations::where('reservation_status',1)->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-d 00:00:00',strtotime('-7 days')))->get();
        $monthly = Reservations::where('reservation_status',1)->orderBy('created_at','desc')->where('company_id',Auth::user()->company->id)->where('created_at', '>', date('Y-m-01 00:00:00'))->get();
        $count_today = $today->count();
        $sum_today = $today->sum('price');
        $count_sevenday = $sevenday->count();
        $sum_sevenday = $sevenday->sum('price');
        $count_monthly = $monthly->count();
        $sum_monthly = $monthly->sum('price');

        $reservations_data = [
            'recent_reservations' => $recent_reservations,
            'today'=> $today,
            'sevenday' => $sevenday,
            'monthly' => $monthly,
            'count_today' => $count_today,
            'sum_today' => $sum_today,
            'count_sevenday' => $count_sevenday,
            'sum_sevenday' => $sum_sevenday,
            'count_monthly' => $count_monthly,
            'sum_monthly' => $sum_monthly,
            'helper' => new Helper(),
        ];

        return view('dashboard',$reservations_data);
    }
}
