<?php

namespace App\Http\Controllers;

use Calendar;
use App\Models\Reservations;
use App\Models\Rooms;
use Illuminate\Http\Request;

class ReservationsController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('reservations.list');
    }

    public function today()
    {
        //
        return view('reservations.list')->with('today','today');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('reservations.form')->with('create','create');
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

        $reservation = new Reservations;
        $room = Rooms::find($request->input('room'));
        $roombooked= $room->reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in)->first();

        if($roombooked){
            return redirect('/reservations/create')->with('error','Selected Room Already Booked On Specified Dates');
        }else{
            $days = date_diff(date_create($check_in),date_create($check_out))->format("%a");

            $price = ($room->price - ($room->price*($request->input('discount')/100)))*$days;

            $reservation->room_id = $request->input('room');
            $reservation->guest_id = $request->input('guest');
            $reservation->check_in = $check_in;
            $reservation->check_out = $check_out;
            $reservation->adults = $request->input('adults');
            $reservation->children = $request->input('children');
            $reservation->reservation_status = $request->input('status');
            $reservation->discount = $request->input('discount');
            $reservation->price = $price;
            $reservation->company_id = auth()->user()->company->id;
            $reservation->created_by = auth()->user()->id;

            $reservation->save();
            return redirect('/reservations/calendar')->with('success','Reservation Record Saved Successfully');
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
        return view('reservations.show')->with('reservation',$reservation);
    }

    public function calendar()
    {
        //
        return view('reservations.calendar');
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
        return view('reservations.form')->with('reservation',$reservation);
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
            $reservation->adults = $request->input('adults');
            $reservation->children = $request->input('children');
            $reservation->reservation_status = $request->input('status');
            $reservation->discount = $request->input('discount');
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
        $reservation->delete();
        return redirect('/reservations')->with('success','Reservation Record Deleted Successfully');
    }
}
