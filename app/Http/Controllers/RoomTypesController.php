<?php

namespace App\Http\Controllers;

use App\Models\RoomTypes;
// use App\Models\RoomTypes;
use Illuminate\Http\Request;

class RoomTypesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except'=>['homepage_rooms','homepage_room_details']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('roomtypes.list',['all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('roomtypes.form')->with('create','create');
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
        $this->validate($request,[
            'name'=>'required',
            'price_from'=>'required',
            'bed_type'=>'required',
            'max_persons'=>'required',
            'category'=>'required',
            'image_one'=>'required'
        ]);

        $roomtype = new RoomTypes;

        $roomtype->name = $request->input('name');
        $roomtype->price_from = $request->input('price_from');
        $roomtype->bed_type = $request->input('bed_type');
        $roomtype->max_persons = $request->input('max_persons');
        $roomtype->category = $request->input('category');
        $roomtype->image_one = $request->input('image_one');
        $roomtype->image_two = $request->input('image_two');
        $roomtype->image_three = $request->input('image_three');
        $roomtype->description = $request->input('description');
        $roomtype->company_id = auth()->user()->company->id;
        $roomtype->created_by = auth()->user()->id;

        // dd($roomtype);
        $roomtype->save();
        return back()->with('success','Room Type Successfully Created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomTypes  $roomtypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $room = RoomTypes::find($id);
        return view('roomtypes.show')->with('room',$room);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomTypes  $roomtypes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $room = RoomTypes::find($id);

        return view('roomtypes.form')->with('room',$room);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomTypes  $roomtypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request,[
            'name'=>'required',
            'price_from'=>'required',
            'type'=>'required',
            'max_persons'=>'required',
            'status'=>'required'
        ]);

        $room = RoomTypes::find($id);

        $room->name = $request->input('name');
        $room->price_from = $request->input('price_from');
        $room->room_type_id = $request->input('type');
        $room->max_persons = $request->input('max_persons');
        $room->status = $request->input('status');

        $room->update();
        return redirect('/roomtypes')->with('success','Successfully Updated!');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTypes  $roomtypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        return RoomTypes::find($id)->delete();
    }

    public function homepage_rooms()
    {
        //
        $data = [
            'rooms'=>RoomTypes::all()
        ];
        return view('homepage.rooms',$data);
    }
    public function homepage_room_details($name)
    {
        //
        $room = RoomTypes::where('name',$name)->first();
        $data = [
            'room'=>$room
        ];
        return view('homepage.roomdetails',$data);
    }
}
