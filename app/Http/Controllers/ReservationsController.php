<?php

namespace App\Http\Controllers;

use Calendar;
use App\Reservations;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
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
            'check_in' => 'required',
            'check_out' => 'required',
            'adults' => 'required',
            'children' => 'required'
        ]);

        $reservation = new Reservations;

        $reservation->room_id = $request->input('room');
        $reservation->guest_id = $request->input('guest');
        $reservation->check_in = $request->input('check_in');
        $reservation->check_out = $request->input('check_out');
        $reservation->adults = $request->input('adults');
        $reservation->children = $request->input('children');
        $reservation->reservation_status = $request->input('status');

        $reservation->save();
        return redirect('/reservations')->with('success','Reservation Record Saved Successfully');
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
    public function edit(Reservations $reservations)
    {
        //
        $reservation = Reservations::find($id);
        return view('reservations.form');
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
            'check_in' => 'required',
            'check_out' => 'required',
            'adults' => 'required',
            'children' => 'required'
        ]);

        $reservation = Reservations::find($id);

        $reservation->room_id = $request->input('room');
        $reservation->guest_id = $request->input('guest');
        $reservation->check_in = $request->input('check_in');
        $reservation->check_out = $request->input('check_out');
        $reservation->adults = $request->input('adults');
        $reservation->children = $request->input('children');
        $reservation->reservation_status = $request->input('status');

        $reservation->save();
        return redirect('/reservations')->with('success','Reservation Record Updated Successfully');
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
