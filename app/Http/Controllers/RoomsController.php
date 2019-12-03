<?php

namespace App\Http\Controllers;

use App\Rooms;
use App\RoomTypes;
use Illuminate\Http\Request;

class RoomsController extends Controller
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
        return view('rooms.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('rooms.form')->with('create','create');
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
        $this->validate($request,[
            'name'=>'required',
            'price'=>'required',
            'type'=>'required',
            'max_persons'=>'required'
        ]);

        $room = new Rooms;

        $room->name = $request->input('name');
        $room->price = $request->input('price');
        $room->room_type_id = $request->input('type');
        $room->max_persons = $request->input('max_persons');
        $room->status = $request->input('status');
        $room->company_id = auth()->user()->company->id;
        $room->created_by = auth()->user()->id;

        $room->save();
        return redirect('/rooms')->with('success','Successfully Created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $room = Rooms::find($id);
        return view('rooms.show')->with('room',$room);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $room = Rooms::find($id);
        
        return view('rooms.form')->with('room',$room);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'name'=>'required',
            'price'=>'required',
            'type'=>'required',
            'max_persons'=>'required'
        ]);

        $room = Rooms::find($id);

        $room->name = $request->input('name');
        $room->price = $request->input('price');
        $room->room_type_id = $request->input('type');
        $room->max_persons = $request->input('max_persons');
        $room->status = $request->input('status');

        $room->update();
        return redirect('/rooms')->with('success','Successfully Updated!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Rooms::find($id)->delete();
        return redirect('/rooms')->with('success','Successfully Deleted!');
    }
}
