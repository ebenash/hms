<?php

namespace App\Http\Controllers;

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
        if ($request->filter_type == 'today') {
            # code...
            return $this->today($request);
        }else if ($request->filter_type == 'requests') {
            # code...
            return $this->requests($request);
        }else if ($request->filter_type == 'cancelled') {
            # code...
            return $this->cancelled($request);
        } else {
            # code...
            return $this->confirmed($request);
        }
    }
    public function confirmed(Request $request)
    {
        //
        $reservations = Reservations::orderBy('created_at','desc')->where('check_in','>',date("Y-m-d", strtotime('-30 days')))->where('company_id',auth()->user()->company->id)->where('reservation_status','confirmed');
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
            'all_reservations' => $reservations->orderBy('check_in','desc')->get(),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('confirmed','confirmed');
    }

    public function today(Request $request)
    {
        //
        $reservations = Reservations::orderBy('created_at','desc')->where('company_id',auth()->user()->company->id)->where('check_in',date('Y-m-d'))->where('reservation_status','confirmed');
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
            'all_reservations' => $reservations->orderBy('check_in','desc')->get(),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('today','today');
    }

    public function requests(Request $request)
    {
        //
        $reservations = Reservations::orderBy('created_at','desc')->where('check_in','>',date("Y-m-d", strtotime('-30 days')))->where('company_id',auth()->user()->company->id)->where('reservation_status','pending');
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
            'all_reservations' => $reservations->orderBy('check_in','desc')->get(),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('requests','requests');
    }
    public function cancelled(Request $request)
    {
        //
        $reservations = Reservations::orderBy('created_at','desc')->where('check_in','>',date("Y-m-d", strtotime('-30 days')))->where('company_id',auth()->user()->company->id)->where('reservation_status','cancelled');
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
            'all_reservations' => $reservations->orderBy('check_in','desc')->get(),
            'filter' => $response
        ];
        return view('reservations.list',$data)->with('cancelled','cancelled');
    }


    public function tomorrow(Request $request)
    {
        // dd(date('Y-m-d', strtotime('tomorrow')));
        $reservations = Reservations::orderBy('created_at','desc')->where('company_id',auth()->user()->company->id)->where('check_in',date('Y-m-d', strtotime('tomorrow')))->where('reservation_status','confirmed');

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'all_reservations' => $reservations->get()
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
                        'currency' => $request->input('currency'),
                        'payment_method' => $request->input('payment_type'),
                        'price' => $price,
                        'company_id' => auth()->user()->company->id,
                        'created_by' => auth()->user()->id,
                    ];

                    $reservations[] = $reservation;
                }
            }
            DB::beginTransaction();
            DB::table('reservations')->insert($reservations);
            DB::commit();

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request. Please Contact The Hotel Directly.');
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
                $feedbacksent = $this->send_feedback_to_guest($resrequest);
                if($feedbacksent){
                    return redirect()->route('reservations-calendar')->with('success','Reservation Record Updated Successfully');
                }else{
                    return redirect()->route('reservations-calendar')->with('warning','Reservation Record Updated But Could Not Send Feedback To Guest. Please try Again');
                }
            }

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request. Please Contact The Hotel Directly.');
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
        $reservation = Reservations::with('roomtype')->find($id);

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => $reservation,
            'req_rooms' => $reservation->roomtype->rooms->where('status',1),
            'request' => 'request'
        ];
        // dd($data);
        return view('reservations.form',$data);
    }

    public function calendar()
    {
        //
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
        $request->validate([
            'room' => 'required',
            'guest' => 'required',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required',
            'children' => 'required'
        ]);

        $check_in = date_format(date_create($request->input('check_in')),"Y/m/d H:i:s");
        $check_out = date_format(date_create($request->input('check_out')),"Y/m/d H:i:s");

        $reservation = Reservations::find($id);
        $room = Rooms::find($request->input('room'));
        $roombooked= $room->reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->first();
        $same = false;

        if($roombooked){
            $same = $room->reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->where('id',$reservation->id)->first();
        }else{
            $same = true;
        }
        if(!$same){
            return redirect('/reservations/'.$id.'/edit')->with('error','Selected Room Already Booked On Specified Dates');
         }else{
            $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

            $price = ($room->price - ($room->price*($request->input('discount')/100)))*$days;

            $reservation->room_id = $request->input('room');
            $reservation->guest_id = $request->input('guest');
            $reservation->check_in = $check_in;
            $reservation->check_out = $check_out;
            $reservation->days = $days;
            $reservation->adults = $request->input('adults');
            $reservation->children = $request->input('children');
            $reservation->reservation_status = $request->input('status');
            $reservation->discount = $request->input('discount');
            $reservation->currency = $request->input('currency');
            $reservation->price = $price;

            $reservation->update();
            return redirect('/reservations')->with('success','Reservation Record Updated Successfully');
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
    public function send_feedback_to_guest($reservation)
    {
        try {
            Notification::route('mail', $reservation->guest->email)->notify(new RequestResponseNotification($reservation));
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
                'payment_method' => 'electronic',
                'company_id' => 1,
                'created_by' => 0,
            ]);

            DB::commit();

            $this->hotel_notification( "New Reservation From ".$request->input('bookNowFullName'), 'success', route('reservations-view-request',$reservation_id) );
            $this->send_admin_notification();

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation Request. Please Contact The Hotel Directly.');
        }

         return back()->with('success','Reservation Request Recorded Successfully');
    }
}
