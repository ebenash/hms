<?php

namespace App\Http\Controllers;


use DateTime;
use App\Models\Payments;
use App\Models\Guests;
use App\Helpers\Helper;
use App\Models\Reservations;
use App\Models\Rooms;
use App\Models\RoomTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Acaronlex\LaravelCalendar\Calendar;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestResponseNotification;
use App\Notifications\RequestRejectedNotification;

class ReservationsController extends CommonController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['homepage_reservation','homepage_reservation_store']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return redirect()->route('reservations-today');
    }
    public function filter(Request $request)
    {
        //
        // dump($request->filter_type);
        if ($request->filter_type == 'today') {
            # code...
            return redirect()->route('reservations-today',$request);
        }else if ($request->filter_type == 'requests') {
            # code...
            return redirect()->route('reservations-requests',$request);
        }else if ($request->filter_type == 'pending') {
            # code...
            return redirect()->route('reservations-pending',$request);
        }else if ($request->filter_type == 'cancelled') {
            # code...
            return redirect()->route('reservations-cancelled',$request);
        }else if ($request->filter_type == 'rejected') {
            # code...
            return redirect()->route('reservations-rejected',$request);
        } else {
            # code...
            return redirect()->route('reservations-confirmed',$request);
        }
    }
    public function confirmed(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.check_in','>=',date("Y-m-d"))->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','confirmed');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('confirmed','confirmed');
    }

    public function today(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in',date('Y-m-d'))->where('reservations.reservation_status','confirmed');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('today','today');
    }

    public function requests(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.check_in','>=',date("Y-m-d"))->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','pending')->where('reservations.created_by',0);
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('requests','requests');
    }

    public function pending(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')))->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','pending');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('pending','pending');
    }

    public function cancelled(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.check_in','>=',date("Y-m-d"))->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','cancelled');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('cancelled','cancelled');
    }

    public function rejected(Request $request)
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.check_in','>=',date("Y-m-d"))->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','rejected');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $reservations->where("room_type",$room_type);
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $reservations->where("room_id",$room);
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->orderBy('check_in','asc')->paginate(50),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('rejected','rejected');
    }


    public function tomorrow(Request $request)
    {
        // dd(date('Y-m-d', strtotime('tomorrow')));
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('check_in',date('Y-m-d', strtotime('tomorrow')))->where('reservations.reservation_status','confirmed');

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->paginate(50)
        ];
        return view('reservations.list',$data)->with('tomorrow','tomorrow');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
        ];
        return view('reservations.form',$data)->with('create','create');
    }

    public function create_with_guest($id)
    {
        //
        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'guest' => Guests::find($id),
        ];
        return view('reservations.form',$data)->with('create','create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request->all());
        $request->validate([
            'room' => 'required',
            'room_type' => 'required',
            'guest_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required',
            'children' => 'required',
            'currency' => 'required',
            'price' => 'required',
            'payment_type' => 'required',
            'status' => 'required',
        ]);
        try{
            $check_in = date_format(date_create($request->input('check_in')),"Y/m/d H:i:s");
            $check_out = date_format(date_create($request->input('check_out')),"Y/m/d H:i:s");

            $reservations = array();
            $totalamount = 0;
            foreach ($request->input('room') as $key => $room_id) {
                # code...
                $roombooked= Reservations::where('room_id', $room_id)->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->where('reservation_status', 'confirmed')->first();
                // dump($roombooked);
                if($roombooked){
                    return back()->with('error','Selected Room(s) Already Booked On Specified Dates');
                }else{
                    $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

                    $price = $request->input('price');
                    $reservation =[
                        'room_id' => $room_id,
                        'room_type' => $request->input('room_type'),
                        'guest_id' => $request->input('guest_id'),
                        'check_in' => $check_in,
                        'check_out' => $check_out,
                        'days' => $days,
                        'adults' => $request->input('adults'),
                        'children' => $request->input('children'),
                        'reservation_status' => $request->input('status'),
                        // 'discount' => $request->input('discount'),
                        'currency' => "GHS",
                        'payment_method' => $request->input('payment_type'),
                        'price' => $price,
                        'company_id' => auth()->user()->company->id,
                        'created_by' => auth()->user()->id,
                        'created_at' => $this->todaydatetime(),
                    ];

                    $reservations[] = $reservation;
                    $totalamount += $price;
                }
            }

            DB::beginTransaction();
            if (count($reservations) == 1) {
                $reservations = current($reservations);
                // dd($reservations);
                $reservation_id = DB::table('reservations')->insertGetId($reservations);
            }else{
                $reservation_id = null;
                DB::table('reservations')->insert($reservations);
            }
            DB::commit();

            if($request->input('payment_type') == 'paystack'){
                if($reservation_id){
                    $resrequest = Reservations::find($reservation_id);
                    $this->send_feedback_to_guest($resrequest,'invoice');
                }else{
                    // dd($reservation);
                    $item = date_format(new DateTime($reservation['check_in']), 'jS F Y').' - '.date_format(new DateTime($reservation['check_out']), 'jS F Y').": Reservation For Multiple Rooms";
                    $this->send_invoice_to_guest($request->input('guest_id'),$totalamount,"Contact Hotel Directly For Detailed Breakdown",$item);
                }
            }

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request.');
        }
        // dd("Well");
        return redirect()->route('reservations-calendar')->with('success','Reservation Record Saved Successfully');
    }
    public function request_update(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'room' => 'required',
            'price' => 'required',
            'currency' => 'required'
        ]);
        try{
            if (isset($request->hotelresponse) && $request->hotelresponse == 'reject') {
                $resrequest = Reservations::find($id);
                $reservation =[
                    'reservation_status' => 'rejected',
                ];
                DB::beginTransaction();
                DB::table('reservations')->where('id',$id)->update($reservation);
                DB::commit();

                //Notify Guest
                Notification::route('mail', $resrequest->guest->email)->notify(new RequestRejectedNotification($resrequest));

                return redirect()->route('reservations-calendar')->with('success','Reservation Record Updated Successfully');
            }else{
                $resrequest = Reservations::find($id);

                $check_in = date_format(date_create($resrequest->check_in),"Y/m/d H:i:s");
                $check_out = date_format(date_create($resrequest->check_out),"Y/m/d H:i:s");
                $room = $request->input('room');
                $price = $request->input('price');

                $roombooked= Reservations::where('room_id', $room)->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->where('reservation_status', 'confirmed')->first();
                // dump($roombooked);
                if($roombooked){
                    return back()->with('error','Selected Room(s) Already Booked On Specified Dates');
                }else{

                    $reservation =[
                        'room_id' => $room,
                        // 'discount' => $request->input('discount'),
                        'currency' => $request->input('currency'),
                        'price' => $price
                    ];
                    DB::beginTransaction();
                    DB::table('reservations')->where('id',$id)->update($reservation);
                    DB::commit();
                    $resrequest = Reservations::find($id);
                    if(!$resrequest->invoice_sent){
                        $feedbacksent = $this->send_feedback_to_guest($resrequest,'invoice');
                    }else{
                        $feedbacksent = true;
                    }
                    if($feedbacksent){
                        return redirect()->route('reservations-calendar')->with('success','Reservation Record Updated Successfully');
                    }else{
                        return redirect()->route('reservations-calendar')->with('warning','Reservation Record Updated But Could Not Send Feedback To Guest.');
                    }
                }
            }

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $reservation = Reservations::find($id);

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => $reservation,
            'show' => 'show'
        ];
        return view('reservations.form',$data);
    }
    public function view_request($id)
    {
        //
        $reservation = Reservations::find($id);

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => $reservation,
            'req_rooms' => $reservation->roomtype ? $reservation->roomtype->rooms->where('status',1) : [],
            'request' => 'request'
        ];
        // dd($data);
        return view('reservations.form',$data);
    }

    public function calendar()
    {
        //
        $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('rooms','reservations.room_id','=','rooms.id','left')->select('reservations.*','guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in','>',date("Y-m-d", strtotime('-30 days')))->orderBy('reservations.check_in','asc');
        $limit = 3000;
        if($reservations->count() > $limit){
            $reservations->limit($limit);
        }
        $reservations=$reservations->get();

        $callendar_reservation_list = [];
        // dd($reservations);

        foreach ($reservations as $key => $reservation) {
            if($reservation->reservation_status == "pending"){
                if(strtotime($reservation->check_in) < strtotime(date("Y-m-d"))){
                    $color = ['color' => '#FF0000','textColor' => '#fff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
                }else{
                    $color = ['color' => '#f3b760','textColor' => '#FF0000','url' => (auth()->user()->can('respond to reservation requests') ? ($reservation->created_by==0 ? route('reservations-view-request',$reservation->id) : route('reservations-show',$reservation->id)) : route('reservations-show',$reservation->id))];
                }
            }else if($reservation->reservation_status == "confirmed"){
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

        $data = [
            'helper' => new Helper(),
            'callendar_reservation_list' => $callendar_reservation_list
        ];
        return view('reservations.calendar',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $reservation = Reservations::find($id);

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => $reservation,
            'update' => 'update'
        ];
        return view('reservations.form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request->all());
        $request->validate([
            'room' => 'required',
            'room_type' => 'required',
            'guest_id' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required',
            'children' => 'required',
            'currency' => 'required',
            'price' => 'required',
            'payment_type' => 'required',
            'status' => 'required',
        ]);

        $check_in = date_format(date_create($request->input('check_in')),"Y/m/d H:i:s");
        $check_out = date_format(date_create($request->input('check_out')),"Y/m/d H:i:s");

        $reservation = Reservations::find($id);
        $room = Rooms::find($request->input('room'));
        $roombooked= Reservations::where('room_id', $room)->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->where('reservation_status', 'confirmed')->first();
        $same = false;

        if($roombooked){
            $same = $room->reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->where('id',$reservation->id)->first();
        }else{
            $same = true;
        }
        if(!$same){
            return back()->with('error','Selected Room Already Booked On Specified Dates');
        }else{
            $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

            $reservation->room_id = $request->input('room');
            $reservation->room_type = $request->input('room_type');
            $reservation->guest_id = $request->input('guest_id');
            $reservation->check_in = $check_in;
            $reservation->check_out = $check_out;
            $reservation->days = $days;
            $reservation->adults = $request->input('adults');
            $reservation->children = $request->input('children');
            $reservation->reservation_status = $request->input('status');
            // $reservation->discount = $request->input('discount');
            $reservation->currency = $request->input('currency');
            $reservation->payment_method = $request->input('payment_type');
            $reservation->price = $request->input('price');

            $reservation->update();

            return back()->with('success','Reservation Record Updated Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservations  $reservations
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $reservation = Reservations::find($id);

        return $reservation->delete();
    }
    public function send_invoice_to_guest($guest_id,$amount,$note,$item)
    {
        $guest = Guests::find($guest_id);

        try {
            if ($guest->paystack_identifier) {
                $customer = $guest->paystack_identifier;
            }else{
                $customer = $this->getNewPaystackCustomerCode($guest);
            }
            if($customer){
                $this->sendPayStackInvoiceApi(
                    $customer,
                    $note,
                    $item,
                    $amount,
                    1,
                    null,
                    date('Y-m-d', strtotime('+5 days')),
                    null
                );
            }else{
                return false;
            }

            return true;
        } catch (\Exception $e) {
            $this->ExceptionHandler($e);
            return false;
        }

    }

    public function send_feedback_to_guest($reservation,$type)
    {
        try {
            if($type == 'invoice'){
                $note = "Thank you for considering ".$reservation->company->name." for your hospitality needs. We are happy to report that the requested room is available for the dates specified (i.e. ".date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y')."). Please find details below and click on the Pay Now button to confirm your reservation.";
                $item = date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y').": Accommodation in ".$reservation->roomtype->name." for ".$reservation->days." day(s).";
                if ($reservation->guest->paystack_identifier) {
                    $customer = $reservation->guest->paystack_identifier;
                }else{
                    $customer = $this->getNewPaystackCustomerCode($reservation->guest);
                }
                if($customer){
                    $this->sendPayStackInvoiceApi(
                        $customer,
                        $note,
                        $item,
                        $reservation->price/$reservation->days,
                        $reservation->days,
                        null,
                        date('Y-m-d', strtotime('-5 days', strtotime($reservation->check_in))),
                        $reservation->id
                    );
                }else{
                    return false;
                }
            }else if($type == 'email') {
                //Hotel Direct Email
                Notification::route('mail', $reservation->guest->email)->notify(new RequestResponseNotification($reservation));
            }

            return true;
        } catch (\Exception $e) {
            $this->ExceptionHandler($e);
            return false;
        }
    }

    public function homepage_reservation()
    {
        //
        $data = [
            'rooms'=>RoomTypes::all()
        ];
        return view('homepage.reservation',$data);
    }

    public function homepage_reservation_store(Request $request)
    {
        //
        // dump($request->all());
        $request->validate([
            'bookNowRoom' => 'required',
            'bookNowFullName' => 'required',
            'bookNowEmail' => 'required',
            'bookNowPhone' => 'required',
            'bookNowCity' => 'required',
            'bookNowCountry' => 'required',
            'bookNowArrival' => 'required|date_format:"d/m/Y"',
            'bookNowDeparture' => 'required|date_format:"d/m/Y"|after:bookNowArrival',
            'bookNowAdults' => 'required',
            'bookNowKids' => 'required'
        ]);

        $check_in = date_format(date_create(str_replace('/', '-',$request->input('bookNowArrival'))),"Y/m/d H:i:s");
        $check_out = date_format(date_create(str_replace('/', '-',$request->input('bookNowDeparture'))),"Y/m/d H:i:s");
        $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");
        // dd($days);
        try{
            $phone = $this->formatphonenumber($request->input('bookNowPhone'));
            $namearr = explode(" ",$request->input('bookNowFullName'));
            $partname = isset($namearr[0]) ? $namearr[0] : $request->input('bookNowFullName');
            // dd($partname);

            $same = Guests::where("full_name","like","%".$partname."%")->where('email',$request->input('bookNowEmail'))->first();

            DB::beginTransaction();
            if($same){
                $guest_id = $same->id;
                if ($same->phone != $phone) {
                    $same->phone = $phone;
                    $same->update();
                }
            }else{
                $guest_id = DB::table('guests')->insertGetId([
                    'full_name' => $request->input('bookNowFullName'),
                    'email' => $request->input('bookNowEmail'),
                    'phone' => $phone,
                    'city' => $request->input('bookNowCity'),
                    'country' => $request->input('bookNowCountry'),
                    'company_id' => 1,
                    'created_by' => 0,
                ]);
            }

            $reservation_id = DB::table('reservations')->insertGetId([
                'room_type' => $request->input('bookNowRoom'),
                'guest_id' => $guest_id,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'days' => $days,
                'adults' => $request->input('bookNowAdults'),
                'children' => $request->input('bookNowKids'),
                'reservation_status' => 'pending',
                'discount' => null,
                'price' => null,
                'payment_method' => 'paystack',
                'company_id' => 1,
                'created_by' => 0,
                'created_at' => $this->todaydatetime(),
            ]);

            DB::commit();

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request. Please Contact The Hotel Directly.');
        }

        try{
            $this->hotel_notification( "New Reservation From ".$request->input('bookNowFullName'), 'success', route('reservations-view-request',$reservation_id) );
            $this->send_admin_notification($reservation_id);
        }catch(\Exception $e){
            $this->ExceptionHandler($e);
        }
         return back()->with('success','Reservation Request Recorded Successfully');
    }
}
