<?php

namespace App\Http\Controllers;

use App\Models\RoomTypes;
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
        return view('roomtypes.list');
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
        $this->validate($request,['name'=>'required']);

        $roomtype = new RoomTypes;

        $roomtype->name = $request->input('name');
        $roomtype->company_id = auth()->user()->company->id;
        $roomtype->created_by = auth()->user()->id;

        $roomtype->save();

        return redirect('/rooms')->with('success', 'Room Type Successfully Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $roomtype = RoomTypes::find($id);
        return view('roomtypes.show')->with('roomtype',$roomtype);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $roomtype = RoomTypes::find($id);
        return view('roomtypes.form')->with('roomtype',$roomtype);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $roomtype = RoomTypes::find($id);

        $this->validate($request,['name'=>'required']);

        $roomtype->name = $request->input('name');

        $roomtype->update();

        return redirect('/rooms')->with('success','Successfully Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RoomTypes  $roomTypes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        RoomTypes::find($id)->delete();
        return redirect('/roomtypes')->with('success','Successfully Deleted!');
    }
}
