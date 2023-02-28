<?php

namespace App\Http\Controllers;

use App\Models\Guests;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class GuestsController extends CommonController
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
    public function index(Request $request)
    {
        //
        $data = [
            'all_guests' => Guests::where('company_id',auth()->user()->company->id)->paginate(50)
        ];
        return view('guests.list',$data);
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
            'full_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $guest = new Guests;

        $guest->full_name = $request->input('full_name');
        $guest->email = $request->input('email');
        $guest->phone = $this->formatphonenumber($request->input('phone'));
        $guest->city = $request->input('city');
        $guest->country = $request->input('country');
        $guest->company_id = auth()->user()->company->id;
        $guest->created_by = auth()->user()->id;

        $guest->save();

        $request->session()->put('guestdetail',$guest->id);
        return redirect()->route('guests')->with('success','Successfully Created!');

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
            'full_name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        $guest->full_name = $request->input('full_name');
        $guest->email = $request->input('email');
        $guest->phone = $this->formatphonenumber($request->input('phone'));
        $guest->city = $request->input('city');
        $guest->country = $request->input('country');

        $guest->update();
        return back()->with('success','Successfully Updated!');
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
        return back()->with('success','Successfully Deleted!');
    }

    public function find_guest($keyword)
    {
        //
        // dd($keyword);
        $guests = Guests::where("full_name","like","%".$keyword."%")->orWhere("phone","like","%".$keyword."%")->orWhere("email","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->get();

        return response()->json($guests);
    }
}
