<?php

namespace App\Http\Controllers;

use App\Models\HotelNotificationPhones;
use Illuminate\Http\Request;

class HotelNotificationPhonesController extends CommonController
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
        $data = [
            'phones' => HotelNotificationPhones::where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
        ];
        return view('smsnotifications.list',$data);
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
            'phone_name'=>'required',
            'phone_number'=>'required',
            'status'=>'required'
        ]);

        $phone = new HotelNotificationPhones;

        $phone->phone_name = $request->input('phone_name');
        $phone->phone_number = $this->formatphonenumber($request->input('phone_number'));
        $phone->status = $request->input('status');
        $phone->company_id = auth()->user()->company->id;
        $phone->created_by = auth()->user()->id;

        $phone->save();

        return redirect()->route('settings-tab','phones')->with('success', 'Phone Successfully Saved!');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HotelNotificationPhones  $smsnotifications
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $phone = HotelNotificationPhones::find($id);

        $this->validate($request,[
            'phone_name'=>'required',
            'phone_number'=>'required',
            'status'=>'required'
        ]);

        $phone->phone_name = $request->input('phone_name');
        $phone->phone_number = $this->formatphonenumber($request->input('phone_number'));
        $phone->status = $request->input('status');

        $phone->update();

        return redirect()->route('settings-tab','phones')->with('success', 'Phone Successfully Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HotelNotificationPhones  $smsnotifications
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return HotelNotificationPhones::find($id)->delete();
    }
}
