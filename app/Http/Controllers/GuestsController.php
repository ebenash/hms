<?php

namespace App\Http\Controllers;

use App\Guests;
use Illuminate\Http\Request;

class GuestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('guests.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('guests.form')->with('create','create');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $guest = new Guests;
        $guest->first_name = $request->input('first_name');
        $guest->last_name = $request->input('last_name');
        $guest->email = $request->input('email');
        $guest->phone = $request->input('phone');
        $guest->city = $request->input('city');
        $guest->country = $request->input('country');

        $guest->save();

        return redirect('/guests')->with('success','Successfully Created!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Guests  $guests
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $guest = Guests::find($id);
        return view('guests.show')->with('guest',$guest);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Guests  $guests
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $guest = Guests::find($id);
        return view('guests.form')->with('guest',$guest);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Guests  $guests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $guest = Guests::find($id);

        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required'
        ]);

        $guest->first_name = $request->input('first_name');
        $guest->last_name = $request->input('last_name');
        $guest->email = $request->input('email');
        $guest->phone = $request->input('phone');
        $guest->city = $request->input('city');
        $guest->country = $request->input('country');
        
        $guest->update();
        return redirect('/guests')->with('success','Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Guests  $guests
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Guests::find($id)->delete();
        return redirect('/guests')->with('success','Successfully Deleted!');
    }
}
