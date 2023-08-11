<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use App\Models\Reservations;
use App\Http\Controllers\ReservationsController;
use Illuminate\Http\Request;

class PaymentsController extends CommonController
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
    // public function index()
    // {
    //     //
    //     return view('   .list',['all_payments' => Payments::where('company_id',auth()->user()->company->id)->get()]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     //
    //     return view('payments.form')->with('create','create');
    // }

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
            'currency'=>'required',
            'payment_type'=>'required',
            'reservation_id'=>'required',
            'amount_paid'=>'required',
        ]);

        $checkbox = $request->input('send_invoice');

        if(isset($checkbox) && $checkbox = 'on'){
            $reservations = new ReservationsController;
            $result = $reservations->send_feedback_to_guest($request->input('reservation_id'),'invoice');

            if($result){
                return back()->with('success','Payment Successfully Created!');
            }else{
                return back()->with('error','Payment Save Failed!');
            }

        }else{
            $this->validate($request,[
                'received_by'=>'required',
                'vat_invoice_number'=>'required',
            ]);
            if($request->input('amount_paid') <= 0){
                return back()->with('error','Payment Amount Must Be More Than 0!');
            }

            $payment = new Payments;

            $payment->currency = $request->input('currency');
            $payment->provider = $request->input('payment_provider');
            $payment->payment_type = $request->input('payment_type');
            $payment->payment_type_id = $request->input('reservation_id');
            $payment->amount = $request->input('amount_paid')*100;
            $payment->reference = $request->input('reference');
            $payment->vat_invoice_number = $request->input('vat_invoice_number');
            $payment->received_by = ucwords(strtolower($request->input('received_by')));
            $payment->status = 'success';
            $payment->created_at = $this->todaydatetime();

            // dd($payment);
            $reservation = Reservations::find($payment->payment_type_id);
            $reservation->reservation_status = 'confirmed';
            if($reservation->update()){
                $payment->save();
                return back()->with('success','Payment Successfully Created!');
            }else{
                return back()->with('error','Payment Save Failed!');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $room = Payments::find($id);
        return view('payments.show')->with('room',$room);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $room = Payments::find($id);

        return view('payments.form')->with('room',$room);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Payments::find($id)->delete();
    }
}
