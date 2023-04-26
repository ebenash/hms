<?php

namespace App\Http\Controllers;

use PDF;
use App\Models\Reports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\RoomTypes;
use App\Models\Reservations;
use App\Models\ReservationDetails;
use App\Models\ReservationRentals;
use App\Models\ReservationExpenses;
use App\Models\PaystackInvoices;
use Illuminate\Support\Facades\DB;

class ReportsController extends CommonController
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
    public function reportfilter(Request $request)
    {
        //
        return redirect()->route('reports',$request);
    }

    public function index(Request $request)
    {
        //
        $response = $request->all();
        // dd($response);
        if(!empty($response)){
            $invoices = null;
            $reservations = null;
            if(isset($response['filter_type']) && $response['filter_type'] == 'typereservationincome'){
                $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_at', 'guests.full_name','reservations.vat_invoice_number','reservations.ota_reservation_number');
            }else if(isset($response['filter_type']) && $response['filter_type'] == 'typeroomincome'){
                $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->leftJoin('rooms','reservation_details.room_id','=','rooms.id')->join('room_types','room_types.id','=','reservation_details.room_type_id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_at', 'guests.full_name','rooms.name as room_name','reservation_details.price_per_day','room_types.name as room_type','reservations.ota_reservation_number');
            }else if(isset($response['filter_type']) && $response['filter_type'] == 'typeota'){
                $reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_at', 'guests.full_name','reservations.vat_invoice_number','reservations.ota_reservation_number')->where('reservations.payment_method','expedia')->orWhere('reservations.payment_method','booking.com');
            }else if(isset($response['filter_type']) && $response['filter_type'] == 'typesales'){
                $details = ReservationDetails::join('reservations','reservations.id','=','reservation_details.reservations_id')->leftJoin('rooms','reservation_details.room_id','=','rooms.id')->select(DB::raw('reservation_details.reservations_id as id, reservations.paid, reservations.reservation_status, reservations.grand_total, reservations.amount_paid, reservations.balance, reservations.payment_method, reservations.created_at, reservations.vat_invoice_number,reservations.ota_reservation_number,IFNULL(reservation_details.deleted_at,"reservation") as type, IFNULL(rooms.name, "Reservation Undefined Room") as description,IFNULL(reservation_details.deleted_at,"1") as quantity,reservation_details.price_per_day,reservation_details.total_price'));
                $rentals = ReservationRentals::join('reservations','reservations.id','=','reservation_rentals.reservations_id')->select('reservation_rentals.reservations_id as id', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_at', 'reservations.vat_invoice_number','reservations.ota_reservation_number','reservation_rentals.rental_type as type','reservation_rentals.description','reservation_rentals.quantity','reservation_rentals.price','reservation_rentals.total_price');
                $expenses = ReservationExpenses::join('reservations','reservations.id','=','reservation_expenses.reservations_id')->select('reservation_expenses.reservations_id as id', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_at', 'reservations.vat_invoice_number','reservations.ota_reservation_number','reservation_expenses.expense_type as type','reservation_expenses.description','reservation_expenses.quantity','reservation_expenses.price','reservation_expenses.total_price');
                $other_expenses = ReservationExpenses::whereNull('reservations_id')->select(DB::raw('IFNULL(reservation_expenses.reservations_id, NULL) as id, IFNULL(reservation_expenses.reservations_id, "full") as paid, IF(reservation_expenses.status = "paid", "confirmed",reservation_expenses.status) as reservation_status, reservation_expenses.total_price as grand_total, IF(reservation_expenses.status = "paid", reservation_expenses.total_price , 0) as amount_paid, IF(reservation_expenses.status = "paid", 0, reservation_expenses.total_price) as balance, reservation_expenses.method as payment_method, reservation_expenses.created_at, IFNULL(reservation_expenses.reservations_id, "") as vat_invoice_number,IFNULL(reservation_expenses.reservations_id, "") as ota_reservation_number,reservation_expenses.expense_type as type,reservation_expenses.description,reservation_expenses.quantity,reservation_expenses.price,reservation_expenses.total_price'));
            }else if(isset($response['filter_type']) && $response['filter_type'] == 'typepaystack'){
                $invoices = PaystackInvoices::leftJoin('guests','paystack_invoices.customer','=','guests.paystack_identifier')->select('guests.full_name','paystack_invoices.*');
            }
            // dd($details->get());
            if(isset($response['search'])){
                $search = $response['search'];
                if($reservations){
                    $reservations->where(function ($query) use ($search){
                        $query->where('guests.full_name', 'like', '%'.$search.'%')->orWhere('reservations.payment_method', 'like', '%'.$search.'%')->orWhere('reservations.vat_invoice_number', 'like', '%'.$search.'%')->orWhere('reservations.ota_reservation_number', 'like', '%'.$search.'%');
                    });
                    if(isset($response['filter_type']) && $response['filter_type'] == 'typeroomincome'){
                        $reservations->orWhere(function ($query) use ($search){
                            $query->orWhere('rooms.name', 'like', '%'.$search.'%')->orWhere('room_types.name', 'like', '%'.$search.'%');
                        });
                    }
                }else if($invoices){
                    $invoices->where(function ($query) use ($search){
                        $query->where('guests.full_name', 'like', '%'.$search.'%')->orWhere('paystack_invoices.invoice_id', 'like', '%'.$search.'%')->orWhere('paystack_invoices.invoice_number', 'like', '%'.$search.'%')->orWhere('paystack_invoices.reservation_id', 'like', '%'.$search.'%')->orWhere('paystack_invoices.request_code', 'like', '%'.$search.'%')->orWhere('paystack_invoices.status', 'like', '%'.$search.'%');
                    });
                }
            }
            if(isset($response['reservation_status'])){
                if($reservations){
                    $reservation_status = $response['reservation_status'];
                    $reservations->where('reservation_status',$reservation_status);
                }
            }
            if(isset($response['daterange'])){
                $daterange = explode(" to ",$response['daterange']);
                $check_in = isset($daterange[0]) ? $daterange[0] : null;
                $check_out = isset($daterange[1]) ? $daterange[1] : null;
                if($reservations){
                    if ($check_out) {
                        $reservations->where('check_in', '<=', $check_out)->where('check_out', '>=', $check_in);
                    }else{
                        $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
                    }
                }else if($invoices){
                    $invoices->where('created_at', '<=', $check_out)->where('created_at', '>=', $check_in);
                }else if(isset($response['filter_type']) && $response['filter_type'] == 'typesales'){
                    if ($check_out) {
                        $details->where('reservations.check_in', '<=', $check_out)->where('reservations.check_out', '>=', $check_in);
                        $rentals->where('reservations.check_in', '<=', $check_out)->where('reservations.check_out', '>=', $check_in);
                        $expenses->where('reservations.check_in', '<=', $check_out)->where('reservations.check_out', '>=', $check_in);
                        $other_expenses->where('reservation_expenses.created_at', '<=', $check_out)->where('reservation_expenses.created_at', '>=', $check_in);
                    }else{
                        $details->where('reservations.check_in', '<=', $check_in)->where('reservations.check_out', '>=', $check_in);
                        $rentals->where('reservations.check_in', '<=', $check_in)->where('reservations.check_out', '>=', $check_in);
                        $expenses->where('reservations.check_in', '<=', $check_in)->where('reservations.check_out', '>=', $check_in);
                        $other_expenses->where('reservation_expenses.created_at', '<=', $check_in)->where('reservation_expenses.created_at', '>=', $check_in);
                    }
                }
            }
            if(isset($response['filter_type']) && $response['filter_type'] == 'typesales'){
                $merge1 = array_merge($details->get()->toArray(), $rentals->get()->toArray());
                $merge2 = array_merge($merge1, $expenses->get()->toArray());
                $sales = array_merge($merge2, $other_expenses->get()->toArray());
            }

            $data = [
                'filter' => $this->objectify([
                    'search'=> $response['search'] ?? "",
                    'filter_type'=> $response['filter_type'] ?? null,
                    'reservation_status'=> $response['reservation_status'] ?? null,
                    'daterange'=> $response['daterange'] ?? null,
                ]),
                'reports' => $reservations ? $reservations->orderBy('check_in','desc')->paginate(200) : ($invoices ? $invoices->orderBy('created_at','desc')->paginate(200) : ($sales ? $this->paginate($this->objectify($sales),200) : null)),
            ];
        }else{
            $data['reports'] = Reservations::where('company_id',auth()->user()->company->id)->orderBy('check_in','desc')->paginate(1);
        }
        // dd($data);
        return view('reports.filter',$data)->with('success','Report Generated');
    }

    public function excelexport(Request $request)
    {
        //
        $exportArray = [];
        if($request->input('filter_type') == 1){

        }else if($request->input('filter_type') == 2){

        }else if($request->input('filter_type') == 3){

        }else if($request->input('filter_type') == 4){

        }

        $start_date = date_format(date_create($request->input('start_date')),"Y/m/d H:i:s");
        $end_date = date_format(date_create($request->input('end_date')),"Y/m/d H:i:s");

        if($request->input('filter_type') == 1){
            $title = "Guests";
            $exportArray[] = ['id','guest_name','phone','email','city','country','created_at','created_by'];
            $all_data = Guests::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->first_name.' '.$data->last_name, $data->phone,$data->email,$data->city,$data->country,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('filter_type') == 2){
            $title = "Reservations";
            $exportArray[] = ['id','guest_name','phone','email','room_name','roomtype','check_in','check_out','adults','children','reservation_status','discount','created_at','created_by'];
            $all_data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->guest->first_name.' '.$data->guest->last_name, $data->phone,$data->email,$data->room->name,$data->room->roomtype->name,date_format(date_create($data->check_in), 'jS F, Y'),date_format(date_create($data->check_out), 'jS F, Y'),$data->adults,$data->children,$data->reservation_status,$data->discount.'%',date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('filter_type') == 3){
            $title = "Rooms";
            $exportArray[] = ['id','room_name','roomtype','grand_total','max_persons','status','created_at','created_by'];
            $all_data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->name,$data->roomtype->name,$data->grand_total,$data->max_persons,$data->status,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('filter_type') == 4){
            $title = "SalesRevenue";
            $exportArray[] = ['id','guest_name','room_name','roomtype','check_in','check_out','reservation_status','days','room_grand_total','discount','total_amount','created_at','created_by'];
            $all_data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->guest->first_name.' '.$data->guest->last_name, $data->room->name,$data->room->roomtype->name,date_format(date_create($data->check_in), 'jS F, Y'),date_format(date_create($data->check_out), 'jS F, Y'),$data->reservation_status,date_diff(date_create($data->check_in),date_create($data->check_out))->format("%a"),$data->room->grand_total,$data->discount.'%',$data->grand_total,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }
        //die(print_r($exportArray));
        return Excel::download(new ReportsExport($exportArray), $title.'Report-'.time().'.xlsx');
    }

    public function pdfexport(Request $request)
    {
        //
        $start_date = date_format(date_create($request->input('start_date')),"Y/m/d H:i:s");
        $end_date = date_format(date_create($request->input('end_date')),"Y/m/d H:i:s");

        if($request->input('filter_type') == 1){
            $title = "Guests";
            $data = Guests::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('filter_type') == 2 || $request->input('filter_type') == 4){
            $title = "Reservations";
            if($request->input('filter_type') == 4){ $title = "SalesRevenue"; }
            $data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('filter_type') == 3){
            $title = "Rooms";
            $data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }

        $filter = [
            'filter_type'=>$request->input('filter_type'),
            'data'=>$data
        ];

        $pdf = PDF::loadView('reports.pdfreport', compact('filter'))->setPaper('a4', 'landscape')->setWarnings(false);
        return $pdf->stream($title.'Report-'.time().'.pdf');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function show(Reports $reports)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function edit(Reports $reports)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reports $reports)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reports  $reports
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reports $reports)
    {
        //
    }
}
