<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use PDF;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\Reservations;

class ReportsController extends Controller
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
        return view('reports.filter');
    }

    public function reportfilter(Request $request)
    {
        //
        $request->validate([
            'report_type'=>'required',
            'start_date'=>'date',
            'end_date'=>'date|after:start_date'
            ]);

        $start_date = date_format(date_create($request->input('start_date')),"Y/m/d H:i:s");
        $end_date = date_format(date_create($request->input('end_date')),"Y/m/d H:i:s");

        if($request->input('report_type') == 1){
            $data = Guests::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('report_type') == 2 || $request->input('report_type') == 4){
            $data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('report_type') == 3){
            $data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }

        $filter = [
            'data'=>$data,
            'report_type'=>$request->input('report_type'),
            'start_date'=>$request->input('start_date'),
            'end_date'=>$request->input('end_date')
        ];
        return view('reports.filter')->with('filter',$filter);
    }

    public function excelexport(Request $request)
    {
        //
        $exportArray = [];
        if($request->input('report_type') == 1){

        }else if($request->input('report_type') == 2){

        }else if($request->input('report_type') == 3){

        }else if($request->input('report_type') == 4){

        }

        $start_date = date_format(date_create($request->input('start_date')),"Y/m/d H:i:s");
        $end_date = date_format(date_create($request->input('end_date')),"Y/m/d H:i:s");

        if($request->input('report_type') == 1){
            $title = "Guests";
            $exportArray[] = ['id','guest_name','phone','email','city','country','created_at','created_by'];
            $all_data = Guests::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->first_name.' '.$data->last_name, $data->phone,$data->email,$data->city,$data->country,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('report_type') == 2){
            $title = "Reservations";
            $exportArray[] = ['id','guest_name','phone','email','room_name','roomtype','check_in','check_out','adults','children','reservation_status','discount','created_at','created_by'];
            $all_data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->guest->first_name.' '.$data->guest->last_name, $data->phone,$data->email,$data->room->name,$data->room->roomtype->name,date_format(date_create($data->check_in), 'jS F, Y'),date_format(date_create($data->check_out), 'jS F, Y'),$data->adults,$data->children,$data->reservation_status,$data->discount.'%',date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('report_type') == 3){
            $title = "Rooms";
            $exportArray[] = ['id','room_name','roomtype','price','max_persons','status','created_at','created_by'];
            $all_data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->name,$data->roomtype->name,$data->price,$data->max_persons,$data->status,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('report_type') == 4){
            $title = "SalesRevenue";
            $exportArray[] = ['id','guest_name','room_name','roomtype','check_in','check_out','reservation_status','days','room_price','discount','total_amount','created_at','created_by'];
            $all_data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->guest->first_name.' '.$data->guest->last_name, $data->room->name,$data->room->roomtype->name,date_format(date_create($data->check_in), 'jS F, Y'),date_format(date_create($data->check_out), 'jS F, Y'),$data->reservation_status,date_diff(date_create($data->check_in),date_create($data->check_out))->format("%a"),$data->room->price,$data->discount.'%',$data->price,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
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

        if($request->input('report_type') == 1){
            $title = "Guests";
            $data = Guests::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('report_type') == 2 || $request->input('report_type') == 4){
            $title = "Reservations";
            if($request->input('report_type') == 4){ $title = "SalesRevenue"; }
            $data = Reservations::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }else if($request->input('report_type') == 3){
            $title = "Rooms";
            $data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();
        }

        $filter = [
            'report_type'=>$request->input('report_type'),
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
