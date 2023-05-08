<?php

namespace App\Http\Controllers;


use DateTime;
use App\Models\Payments;
use App\Models\Guests;
use App\Helpers\Helper;
use App\Models\Reservations;
use App\Models\ReservationDetails;
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
        // $this->send_feedback_to_guest(4,'invoice');
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','confirmed');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }else{
            $reservations->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')));
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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in',date('Y-m-d'))->where('reservations.reservation_status','confirmed');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        // if(isset($response['daterange'])){
        //     $daterange = explode(" to ",$response['daterange']);
        //     $check_in = isset($daterange[0]) ? $daterange[0] : null;
        //     $check_out = isset($daterange[1]) ? $daterange[1] : null;
        //     if ($check_out) {
        //         $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
        //     }else{
        //         $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
        //     }
        // }

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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','pending')->where('reservations.created_by',0);
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }else{
            $reservations->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')));
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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','pending');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }else{
            $reservations->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')));
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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','cancelled');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }else{
            $reservations->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')));
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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.reservation_status','rejected');
        $response = $request->all();
        // dd($response);
        if(isset($response['guest'])){
            $search = $response['guest'];
            $guests = Guests::select(['id'])->where('full_name', 'like', '%'.$search.'%')->get()->toArray();
            $reservations->whereIn("guest_id",array_column($guests, 'id'));
        }
        if(isset($response['room_type'])){
            $room_type = $response['room_type'];
            $details = ReservationDetails::where("room_type_id",$room_type)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['room'])){
            $room = $response['room'];
            $details = ReservationDetails::where("room_id",$room)->get();
            $reservations->whereIn("reservations.id",array_column($details->toArray(), 'reservations_id'));
        }
        if(isset($response['daterange'])){
            $daterange = explode(" to ",$response['daterange']);
            $check_in = isset($daterange[0]) ? $daterange[0] : null;
            $check_out = isset($daterange[1]) ? $daterange[1] : null;
            if ($check_out) {
                $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }
        }else{
            $reservations->where('reservations.check_in','>=',date("Y-m-d", strtotime('-5 days')));
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
        $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.*','guests.full_name')->where('reservations.company_id',auth()->user()->company->id)->where('check_in',date('Y-m-d', strtotime('tomorrow')))->where('reservations.reservation_status','confirmed');

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
        // dd($request->all());
        $request->validate([
            'guest_id' => 'required',
            'reservation_daterange' => 'required',
            // 'room1' => 'required',
            // 'room_type1' => 'required',
            // 'adults1' => 'required',
            // 'children1' => 'required',
            // 'total_price1' => 'required',
            'roomtypecount' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'grand_total' => 'required',
            'payment_type' => 'required',
            'status' => 'required',
            'signed_by' => 'required',
        ]);

        try{

            $dates = explode(' to ', $request->input('reservation_daterange'));
            // dd($dates);
            $check_in = date_format(date_create($dates[0]),"Y/m/d H:i:s");
            $check_out = date_format(date_create($dates[1]),"Y/m/d H:i:s");
            $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

            $reservation_details = array();
            $reservation_rentals = array();
            $reservation_expenses = array();

            $totalamount = 0;

            DB::beginTransaction();

            $reservation_id = DB::table('reservations')->insertGetId([
                'guest_id' => $request->input('guest_id'),
                'check_in' => $check_in,
                'check_out' => $check_out,
                'days' => $days,
                'reservation_status' => $request->input('status'),
                'currency' => "GHS",
                'grand_total' => $request->input('grand_total'),
                'amount_paid' => $request->input('amount_paid'),
                'balance' => $request->input('balance'),
                'payment_method' => $request->input('payment_type'),
                'invoice_sent' => false,
                'paid' => $request->input('payment_type') != 'paystack' && ($request->input('status') == 'confirmed' && $request->input('balance') == 0) ? 'full' : ($request->input('amount_paid') != 0 && $request->input('status') == 'confirmed' ? 'part': 'pending'),
                'notes' => $request->input('notes') ?? "",
                'vat_invoice_number' => $request->input('vat_invoice_number'),
                'ota_reservation_number' => $request->input('ota_reservation_number'),
                'signed_by' => $request->input('signed_by'),
                'company_id' => auth()->user()->company->id,
                'created_by' => auth()->user()->id,
                'created_at' => $this->todaydatetime(),
            ]);

            for ($i=1; $i < $request->input('roomtypecount')+1; $i++) {
                # code...
                foreach ($request->input('room'.$i) as $key => $room_id) {
                    # code...
                    $roombooked = DB::table('reservation_details')->join('reservations','reservation_details.reservations_id','=','reservations.id')->join('guests','reservations.guest_id','=','guests.id')->select('reservations.id', 'reservation_details.id as detail_id','reservations.check_in','reservations.check_out','reservation_details.room_id','guests.full_name')->where('reservation_details.room_id', $room_id)->where('reservations.check_in', '<', $check_out)->where('reservations.check_out', '>', $check_in)->where('reservations.reservation_status', 'confirmed')->first();
                    // dd($roombooked);
                    if($roombooked){
                        // dd($roombooked);
                        return back()->with('error','Selected Room(s) Already Booked By '.$roombooked->full_name.' (Reservation: #'.$roombooked->id.') On Specified Dates');
                    }else{

                        $total_price = $request->input('total_price'.$i);
                        $reservation_detail =[
                            'reservations_id' => $reservation_id,
                            'room_id' => $room_id,
                            'room_type_id' => $request->input('room_type'.$i),
                            'adults' => $request->input('adults'.$i),
                            'children' => $request->input('children'.$i),
                            'price_per_day' => $request->input('price_per_day'.$i),
                            'total_price' => $total_price,
                            'created_at' => $this->todaydatetime(),
                        ];

                        $reservation_details[] = $reservation_detail;
                        $totalamount += $total_price;
                    }
                }
            }
            for ($i=1; $i < $request->input('rentaltypecount')+1; $i++) {
                if($request->input('rental_type'.$i) == 'grounds'){
                    $rentalbooked = DB::table('reservation_rentals')->join('reservations','reservation_rentals.reservations_id','=','reservations.id')->select('reservations.check_in','reservations.check_out')->where('reservation_rentals.rental_type', $request->input('rental_type'.$i))->where('reservations.check_in', '<', $check_out)->where('reservations.check_out', '>', $check_in)->where('reservations.reservation_status', 'confirmed')->first();
                }else{
                    $rentalbooked = null;
                }
                // dd($rentalbooked);
                if($rentalbooked){
                    return back()->with('error','Grounds Already Booked On Specified Dates');
                }else{

                    $total_price = $request->input('rental_total_price'.$i);
                    $reservation_rental =[
                        'reservations_id' => $reservation_id,
                        'rental_type' => $request->input('rental_type'.$i),
                        'description' => $request->input('rental_description'.$i),
                        'quantity' => $request->input('rental_quantity'.$i),
                        'price' => $request->input('rental_price_per_day'.$i),
                        'total_price' => $total_price,
                        'created_at' => $this->todaydatetime(),
                    ];

                    $reservation_rentals[] = $reservation_rental;
                    $totalamount += $total_price;
                }
            }

            for ($i=1; $i < $request->input('expensetypecount')+1; $i++) {
                $total_price = $request->input('expense_total_price'.$i);
                $reservation_expense =[
                    'reservations_id' => $reservation_id,
                    'expense_type' => $request->input('expense_type'.$i),
                    'description' => $request->input('expense_description'.$i),
                    'quantity' => $request->input('expense_quantity'.$i),
                    'price' => $request->input('expense_price'.$i),
                    'total_price' => $total_price,
                    'created_at' => $this->todaydatetime(),
                ];

                $reservation_expenses[] = $reservation_expense;
                $totalamount += $total_price;
            }
            // dd($reservation_expenses);

            if(count($reservation_details) > 0){
                DB::table('reservation_details')->insert($reservation_details);
            }
            if(count($reservation_rentals) > 0){
                DB::table('reservation_rentals')->insert($reservation_rentals);
            }
            if(count($reservation_expenses) > 0){
                DB::table('reservation_expenses')->insert($reservation_expenses);
            }

            DB::commit();

            if($request->input('payment_type') == 'paystack'){
                $this->send_feedback_to_guest($reservation_id,'invoice');
            }

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Reservation.');
        }
        // dd("Well");
        return redirect()->route('reservations-calendar')->with('success','Reservation Record Saved Successfully');
    }
    public function request_update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'room1' => 'required',
            'grand_total' => 'required',
            'signed_by' => 'required'
        ]);
        try{
            if (isset($request->hotelresponse) && $request->hotelresponse == 'reject') {
                $resrequest = Reservations::find($id);
                $resrequest->reservation_status = 'rejected';
                $resrequest->update();

                //Notify Guest
                Notification::route('mail', $resrequest->guest->email)->notify(new RequestRejectedNotification($resrequest));

                return redirect()->route('reservations-calendar')->with('success','Reservation Record Updated Successfully');
            }else{
                $resrequest = Reservations::find($id);

                $check_in = date_format(date_create($resrequest->check_in),"Y/m/d H:i:s");
                $check_out = date_format(date_create($resrequest->check_out),"Y/m/d H:i:s");
                $grand_total = $request->input('grand_total');

                $reservation =[
                    'grand_total' => $grand_total,
                    'balance' => $request->input('balance'),
                    'amount_paid' => $request->input('amount_paid'),
                    'signed_by' => $request->input('signed_by'),
                    'signed_by' => $resrequest->signed_by != "" ? ", ".$request->input('signed_by') : $request->input('signed_by'),
                ];

                $reservation_details = array();

                for ($i=1; $i < $request->input('roomtypecount')+1; $i++) {
                    # code...
                    // $reservation_details = array();
                    $resdetails = ReservationDetails::where('reservations_id',$id)->where('room_type_id',$request->input('room_type'.$i))->whereNull('room_id')->get();
                    // dump($resdetails);
                    if (count($request->input('room'.$i)) != $resdetails->count()) {
                        return back()->with('error','Selected Number Of Rooms for '.($resdetails->first()->roomtype->name ?? 'Entry').' Does Not Match Number Of Rooms Requested By Guest');
                    }

                    foreach ($request->input('room'.$i) as $key => $room_id) {
                        # code...
                        $roombooked = DB::table('reservation_details')->join('reservations','reservation_details.reservations_id','=','reservations.id')->join('guests','reservations.guest_id','=','guests.id')->select('reservations.id', 'reservation_details.id as detail_id','reservations.check_in','reservations.check_out','reservation_details.room_id','guests.full_name')->where('reservation_details.room_id', $room_id)->where('reservations.check_in', '<', $check_out)->where('reservations.check_out', '>', $check_in)->where('reservations.reservation_status', 'confirmed')->where('reservation_details.reservations_id','!=',$id)->first();
                        // dd($roombooked);
                        if($roombooked){
                            // dd($roombooked);
                            return back()->with('error','Selected Room(s) Already Booked By '.$roombooked->full_name.' (Reservation: #'.$roombooked->id.') On Specified Dates');
                        }else{

                            $total_price = $request->input('total_price'.$i);
                            $reservation_detail =[
                                'reservations_id' => $id,
                                'room_id' => $room_id,
                                'room_type_id' => $request->input('room_type'.$i),
                                'adults' => $request->input('adults'.$i),
                                'children' => $request->input('children'.$i),
                                'price_per_day' => $request->input('price_per_day'.$i),
                                'total_price' => $total_price,
                                'created_at' => $this->todaydatetime(),
                            ];

                            $reservation_details[] = $reservation_detail;
                        }
                    }
                }

                // dd($reservation_details);
                DB::beginTransaction();
                DB::table('reservations')->where('id',$id)->update($reservation);
                if(count($reservation_details) > 0){
                    DB::table('reservation_details')->where('reservations_id',$id)->delete();
                    DB::table('reservation_details')->insert($reservation_details);
                }
                DB::commit();

                if(!$resrequest->invoice_sent){
                    $feedbacksent = $this->send_feedback_to_guest($id,'invoice');
                }else{
                    $feedbacksent = true;
                }
                if($feedbacksent){
                    return redirect()->route('reservations-calendar')->with('success','Reservation Record Updated Successfully');
                }else{
                    return redirect()->route('reservations-calendar')->with('warning','Reservation Record Updated But Could Not Send Feedback To Guest.');
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
        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => Reservations::where('id',$id)->with(['details','rentals','expenses'])->first(),
            'distinctdetails' => ReservationDetails::where('reservations_id',$id)->groupBy('room_type_id')->get(),
            'show' => 'show'
        ];
        // dd($data);
        return view('reservations.form',$data);
    }
    public function view_request($id)
    {
        //
        $reservation = Reservations::find($id);
        $reservation_detail = $reservation->details->first();

        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => $reservation,
            'req_rooms' => $reservation_detail->roomtype ? $reservation_detail->roomtype->rooms->where('status',1) : [],
            'distinctdetails' => ReservationDetails::where('reservations_id',$id)->selectRaw('*, count(1) as requested_number')->groupBy('room_type_id')->get(),
            'request' => 'request'
        ];
        // dd($data);
        return view('reservations.form',$data);
    }

    public function calendar()
    {
        //
        $limit = 1000;
        // $reservations = [];//$this->mysqli_fetch_normal("select `reservations`.*, `guests`.`full_name`, `rooms`.`name` as `roomname` from `reservations` inner join `guests` on `reservations`.`guest_id` = `guests`.`id` left join `rooms` on `reservations`.`room_id` = `rooms`.`id` where `reservations`.`company_id` = ".auth()->user()->company->id." and `reservations`.`check_in` > '".date("Y-m-d", strtotime('-30 days'))."' order by `reservations`.`check_in` asc limit ".$limit."");

        // $reservations = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->leftJoin('rooms','reservation_details.room_id','=','rooms.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as roomname')->where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in','>',date("Y-m-d", strtotime('-30 days')))->orderBy('reservations.check_in','asc')->limit($limit)->get();
        $reservations = Reservations::where('reservations.company_id',auth()->user()->company->id)->where('reservations.check_in','>',date("Y-m-d", strtotime('-30 days')))->with(['guest','details','rentals'])->orderBy('reservations.check_in','asc')->limit($limit)->get();

        $callendar_reservation_list = [];
        // dd($reservations);

        foreach ($reservations as $key => $reservation) {
            $rooms = "";
            $rentals = "";
            foreach ($reservation->details as $detail){
                if($detail->room){
                    $rooms .= ($rooms != "" ? ', '.$detail->room->name : $detail->room->name);
                }
            }
            foreach ($reservation->rentals as $rental){
                $rentals .= ($rentals != "" ? ', '.ucfirst($rental->rental_type) : ucfirst($rental->rental_type));
            }
            // dd($reservation);


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
            }else if($reservation->reservation_status == "confirmed" && $reservation->paid == "pending"){
                $color = ['color' => '#fffb00','textColor' => '#FF0000','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }else{
                $color = ['color' => '#d26a5c','textColor' => '#ffffff','url' => (auth()->user()->can('view reservations') ? route('reservations-show',$reservation->id) : '#')];
            }
            $callendar_reservation_list[] = Calendar::event(
                "#".$reservation->id." ".$reservation->guest->full_name."'s ".(($reservation->reservation_status == "pending" && $reservation->created_by==0) ? (strtotime($reservation->check_in) < strtotime(date("Y-m-d")) ? 'Expired Request: ' : 'Request: ') :'Reservation: ').($rooms != "" ? 'Rooms - ':'').($rooms != "" ? "[".$rooms."]" : ($rentals != "" ? "" : "Unassigned"))." ".($rentals != "" ? 'Rentals - ':'').($rentals != "" ? "[".$rentals."]" : "")." (".ucfirst($reservation->reservation_status)." - ".ucfirst($reservation->paid)." Payment) ".($reservation->payment_method ? ucfirst($reservation->payment_method) : '')."",
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
        $data = [
            'all_rooms' => Rooms::where('status',1)->where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get(),
            'reservation' => Reservations::where('id',$id)->with('details')->first(),
            'distinctdetails' => ReservationDetails::where('reservations_id',$id)->groupBy('room_type_id')->get(),
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
            'guest_id' => 'required',
            'reservation_daterange' => 'required',
            // 'room1' => 'required',
            // 'room_type1' => 'required',
            // 'adults1' => 'required',
            // 'children1' => 'required',
            // 'total_price1' => 'required',
            'roomtypecount' => 'required',
            'amount_paid' => 'required',
            'balance' => 'required',
            'grand_total' => 'required',
            'payment_type' => 'required',
            'status' => 'required',
            'signed_by' => 'required',
        ]);

        try{
            $dates = explode(' to ', $request->input('reservation_daterange'));
            // dd($dates);
            $check_in = date_format(date_create($dates[0]),"Y/m/d H:i:s");
            $check_out = date_format(date_create($dates[1]),"Y/m/d H:i:s");
            $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

            $reservation_details = array();
            $reservation_rentals = array();
            $reservation_expenses = array();

            $totalamount = 0;

            $reservation = Reservations::find($id);

            DB::beginTransaction();

            DB::table('reservations')->where('id',$id)->update([
                'check_in' => $check_in,
                'check_out' => $check_out,
                'days' => $days,
                'reservation_status' => $request->input('status'),
                'grand_total' => $request->input('grand_total'),
                'amount_paid' => $request->input('amount_paid'),
                'balance' => $request->input('balance'),
                'payment_method' => $request->input('payment_type'),
                // 'paid' => $request->input('payment_type') != 'paystack' && ($request->input('status') == 'confirmed' && $request->input('balance') == 0) ? 'full' : ($request->input('amount_paid') != 0 && $request->input('status') == 'confirmed' ? 'part': 'pending'),
                'paid' => ($request->input('status') == 'confirmed' && $request->input('balance') == 0) ? 'full' : ($request->input('amount_paid') != 0 && $request->input('status') == 'confirmed' ? 'part': 'pending'),
                'notes' => $request->input('notes') ?? $reservation->notes,
                'vat_invoice_number' => $request->input('vat_invoice_number'),
                'ota_reservation_number' => $request->input('ota_reservation_number'),
                'signed_by' => $reservation->signed_by.", ".$request->input('signed_by'),
            ]);

            for ($i=1; $i < $request->input('roomtypecount')+1; $i++) {
                # code...
                foreach ($request->input('room'.$i) as $key => $room_id) {
                    # code...
                    $roombooked = DB::table('reservation_details')->join('reservations','reservation_details.reservations_id','=','reservations.id')->join('guests','reservations.guest_id','=','guests.id')->select('reservations.id', 'reservation_details.id as detail_id','reservations.check_in','reservations.check_out','reservation_details.room_id','guests.full_name')->where('reservation_details.room_id', $room_id)->where('reservations.check_in', '<', $check_out)->where('reservations.check_out', '>', $check_in)->where('reservations.reservation_status', 'confirmed')->where('reservation_details.reservations_id','!=',$id)->first();
                    // dd($roombooked);
                    if($roombooked){
                        // dd($roombooked);
                        return back()->with('error','Selected Room(s) Already Booked By '.$roombooked->full_name.' (Reservation: #'.$roombooked->id.') On Specified Dates');
                    }else{

                        $total_price = $request->input('total_price'.$i);
                        $reservation_detail =[
                            'reservations_id' => $id,
                            'room_id' => $room_id,
                            'room_type_id' => $request->input('room_type'.$i),
                            'adults' => $request->input('adults'.$i),
                            'children' => $request->input('children'.$i),
                            'price_per_day' => $request->input('price_per_day'.$i),
                            'total_price' => $total_price,
                            'created_at' => $this->todaydatetime(),
                        ];

                        $reservation_details[] = $reservation_detail;
                        $totalamount += $total_price;
                    }
                }
            }

            for ($i=1; $i < $request->input('rentaltypecount')+1; $i++) {
                if($request->input('rental_type'.$i) == 'grounds'){
                    $rentalbooked = DB::table('reservation_rentals')->join('reservations','reservation_rentals.reservations_id','=','reservations.id')->select('reservations.check_in','reservations.check_out')->where('reservation_rentals.rental_type', $request->input('rental_type'.$i))->where('reservations.check_in', '<', $check_out)->where('reservations.check_out', '>', $check_in)->where('reservations.reservation_status', 'confirmed')->first();
                }else{
                    $rentalbooked = null;
                }
                // dd($rentalbooked);
                if($rentalbooked){
                    return back()->with('error','Grounds Already Booked On Specified Dates');
                }else{

                    $total_price = $request->input('rental_total_price'.$i);
                    $reservation_rental =[
                        'reservations_id' => $id,
                        'rental_type' => $request->input('rental_type'.$i),
                        'description' => $request->input('rental_description'.$i),
                        'quantity' => $request->input('rental_quantity'.$i),
                        'price' => $request->input('rental_price_per_day'.$i),
                        'total_price' => $total_price,
                        'created_at' => $this->todaydatetime(),
                    ];

                    $reservation_rentals[] = $reservation_rental;
                    $totalamount += $total_price;
                }
            }

            for ($i=1; $i < $request->input('expensetypecount')+1; $i++) {
                $total_price = $request->input('expense_total_price'.$i);
                $reservation_expense =[
                    'reservations_id' => $id,
                    'expense_type' => $request->input('expense_type'.$i),
                    'description' => $request->input('expense_description'.$i),
                    'quantity' => $request->input('expense_quantity'.$i),
                    'price' => $request->input('expense_price'.$i),
                    'total_price' => $total_price,
                    'created_at' => $this->todaydatetime(),
                ];

                $reservation_expenses[] = $reservation_expense;
                $totalamount += $total_price;
            }

            if(count($reservation_details) > 0){
                DB::table('reservation_details')->where('reservations_id',$id)->delete();
                DB::table('reservation_details')->insert($reservation_details);
            }
            if(count($reservation_rentals) > 0){
                DB::table('reservation_rentals')->where('reservations_id',$id)->delete();
                DB::table('reservation_rentals')->insert($reservation_rentals);
            }
            if(count($reservation_expenses) > 0){
                DB::table('reservation_expenses')->where('reservations_id',$id)->delete();
                DB::table('reservation_expenses')->insert($reservation_expenses);
            }

            DB::commit();

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Update Reservation.');
        }

        return back()->with('success','Reservation Record Updated Successfully');
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
        try{
            DB::beginTransaction();
            DB::table('reservation_details')->where('reservations_id',$id)->delete();
            DB::table('reservations')->where('id',$id)->delete();
            DB::commit();
            return true;
        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return false;
        }
    }

    public function send_invoice_to_guest($guest_id,$amount,$note,$item)
    {
        dd("NOT DONE");
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

    public function send_feedback_to_guest($reservation_id,$type = 'invoice')
    {
        $reservation = Reservations::find($reservation_id);

        try {
            if($type == 'invoice'){

                $note = "Thank you for considering ".$reservation->company->name." for your hospitality needs. We are happy to report that the requested room(s) is available for the dates specified (i.e. ".date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y')."). Please find details below and click on the Pay Now button to confirm your reservation.";

                if ($reservation->guest->paystack_identifier) {
                    $customer = $reservation->guest->paystack_identifier;
                }else{
                    $customer = $this->getNewPaystackCustomerCode($reservation->guest);
                }
                if($customer){
                    $line_items = array();

                    foreach ($reservation->details as $detail) {
                        $line_items[] = [
                            'name' => date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y').": Accommodation in ".$detail->roomtype->name." for ".$reservation->days." day(s).",
                            'amount' => number_format(($detail->price_per_day*100),0,'.',''),
                            "quantity"=> $reservation->days,
                        ];
                    }
                    foreach ($reservation->rentals as $rental) {
                        $line_items[] = [
                            'name' => date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y').": Rental >> ".$rental->description." for ".$reservation->days." day(s).",
                            'amount' => number_format((($rental->price*$reservation->days)*100),0,'.',''),
                            "quantity"=> $rental->quantity,
                        ];
                    }
                    foreach ($reservation->expenses as $expense) {
                        $line_items[] = [
                            'name' => date_format(new DateTime($reservation->check_in), 'jS F Y').' - '.date_format(new DateTime($reservation->check_out), 'jS F Y').": Additional Bill >> ".$expense->description.".",
                            'amount' => number_format(($expense->price*100),0,'.',''),
                            "quantity"=> $expense->quantity,
                        ];
                    }

                    // dd($line_items);

                    $this->sendPayStackInvoiceApi(
                        $customer,
                        $note,
                        $line_items,
                        $reservation->grand_total,
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
        // dd($request->all());
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
                'guest_id' => $guest_id,
                'check_in' => $check_in,
                'check_out' => $check_out,
                'days' => $days,
                'reservation_status' => $request->input('status'),
                'currency' => "GHS",
                'grand_total' => null,
                'amount_paid' => null,
                'balance' => null,
                'payment_method' => 'paystack',
                'reservation_status' => 'pending',
                'paid' => 'pending',
                'invoice_sent' => false,
                'company_id' => 1,
                'created_by' => 0,
                'created_at' => $this->todaydatetime(),
            ]);

            $reservation_details = array();

            foreach ($request->input('bookNowRoom') as $key => $type) {
                # code...
                $count = 1;
                while ($count <= $request->input('bookNowNum'.$type)) {
                    $reservation_detail = [
                        'reservations_id' => $reservation_id,
                        'room_id' => null,
                        'room_type_id' => $type,
                        'adults' => $request->input('bookNowAdults'),
                        'children' => $request->input('bookNowKids'),
                        'price_per_day' => null,
                        'total_price' => null,
                    ];
                    $reservation_details[] = $reservation_detail;
                    $count++;
                }
            }
            // dd($reservation_details);
            DB::table('reservation_details')->insert($reservation_details);

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
         return back()->with('success','We Have Received Your Reservation Request. Please Expect A Response From Us Shortly!');
    }

}
