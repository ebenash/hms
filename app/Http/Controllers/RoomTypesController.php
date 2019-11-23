<?php

namespace App\Http\Controllers;

use App\RoomTypes;
use Illuminate\Http\Request;

class RoomTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roomtypes = RoomTypes::all();
        return view('roomtypes.list')->with('roomtypes',$roomtypes);
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

        $roomtype->save();

        return redirect('/roomtypes')->with('success', 'Room Type Successfully Saved!');
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

        return redirect('/roomtypes')->with('success','Successfully Updated!');

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
