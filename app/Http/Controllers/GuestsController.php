<?php

namespace App\Http\Controllers;

use App\Models\Guests;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

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
        $paginate = 50;
        if($request->session()->has('guestdetail')) {
            $lastPage = Guests::where('company_id',auth()->user()->company->id)->paginate($paginate)->lastPage();
            Paginator::currentPageResolver(function() use ($lastPage) {
                return $lastPage;
            });
        }
        $data = [
            'all_guests' => Guests::where('company_id',auth()->user()->company->id)->paginate($paginate)
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
        // dd($request->all());
        $this->validate($request,[
            'full_name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'id_card' => 'max:1000|image'
        ]);
        $fullname = ucwords(strtolower($request->input('full_name')));
        $exists = Guests::where('full_name',$fullname)->first();
        // dd($exists);
        if($exists){
            $request->session()->put('guestdetail',$exists->id);
            return redirect()->route('guests')->with('warning','Guest Already Exists In System! Please Edit Guest To Add Extra Details');
        }
        try{
            $guest = new Guests;

            $filename = null;

            $guest->full_name = $fullname;
            $guest->email = strtolower($request->input('email'));
            $guest->phone = $this->formatphonenumber($request->input('phone'));
            $guest->city = $request->input('city');
            $guest->country = $request->input('country');
            if($request->hasFile('id_card')){
                $extension = $request->file('id_card')->getClientOriginalExtension();
                $filename = $guest->full_name."_".time().".".$extension;
                $path = $request->file('id_card')->storeAs('public/uploads/guestids/',$filename);
            }
            $guest->id_card = $filename;
            $guest->company_id = auth()->user()->company->id;
            $guest->created_by = auth()->user()->id;

            $guest->save();

            $request->session()->put('guestdetail',$guest->id);
            return redirect()->route('guests')->with('success','Successfully Created!');
        }catch(\Exception $e){
            $this->ExceptionHandler($e);
        }

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
            'phone' => 'required',
            // 'id_card' => 'image|required'
        ]);

        if(!$guest->id_card){
            $this->validate($request,[
                'id_card' => 'max:1000|image|required'
            ]);
        }

        try{
            if($request->hasFile('id_card')){
                $extension = $request->file('id_card')->getClientOriginalExtension();
                $filename = $guest->full_name."_".time().".".$extension;
                $path = $request->file('id_card')->storeAs('public/uploads/guestids/',$filename);

                if($guest->id_card != null || $guest->id_card != "")
                {
                    unlink(storage_path('app/public/uploads/guestids/'.$guest->id_card));
                }
            }else{
                $filename = $guest->id_card;
            }

            $guest->full_name = ucwords(strtolower($request->input('full_name')));
            $guest->email = strtolower($request->input('email'));
            $guest->phone = $this->formatphonenumber($request->input('phone'));
            $guest->id_card = $filename;
            $guest->city = $request->input('city');
            $guest->country = $request->input('country');

            $guest->update();
            return back()->with('success','Successfully Updated!');}

        catch(\Exception $e){
            $this->ExceptionHandler($e);
        }
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
