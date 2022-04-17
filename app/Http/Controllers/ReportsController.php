<?php

namespace App\Http\Controllers;

use App\Models\Reports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportsExport;
use PDF;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\RoomTypes;
use App\Models\Reservations;

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
        $reservations = Reservations::orderBy('created_at','desc')->where('company_id',auth()->user()->company->id);
        $response = $request->all();
        // dd($response);
        if(!empty($response)){
            if(isset($response['reservation_status'])){
                $reservation_status = $response['reservation_status'];
                $reservations->where('reservation_status',$reservation_status);
            }
            if(isset($response['daterange'])){
                $daterange = explode(" to ",$response['daterange']);
                $check_in = isset($daterange[0]) ? $daterange[0] : null;
                $check_out = isset($daterange[1]) ? $daterange[1] : null;
                if ($check_out) {
                    $reservations->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
                }else{
                    $reservations->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
                }
            }

            $data = [
                'filter' => $this->objectify([
                    'filter_type'=> $response['filter_type'] ?? null,
                    'reservation_status'=> $response['reservation_status'] ?? null,
                    'daterange'=> $response['daterange'] ?? null,
                ]),
                'reservations' => $reservations->orderBy('check_in','desc')->paginate(100),
            ];
        }else{
            $data['reservations'] = $reservations->orderBy('check_in','desc')->paginate(1);
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
            $exportArray[] = ['id','room_name','roomtype','price','max_persons','status','created_at','created_by'];
            $all_data = Rooms::where('created_at', '<=', $end_date)->where('created_at', '>=', $start_date)->where('company_id',auth()->user()->company->id)->get();

            foreach($all_data as $data){
                $exportArray[] = [$data->id,$data->name,$data->roomtype->name,$data->price,$data->max_persons,$data->status,date_format(date_create($data->created_at), 'jS F, Y'),$data->user['name']];
            }
        }else if($request->input('filter_type') == 4){
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
