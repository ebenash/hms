<?php

namespace App\Http\Controllers;

use App\Models\Accounting;
use App\Models\PaystackInvoices;
use App\Models\ReservationExpenses;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccountingController extends CommonController
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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paystack_invoices(Request $request)
    {
        //
        $paginate = 50;
        $data = [
            'all_invoices' => PaystackInvoices::with(['guest','reservation'])->paginate($paginate)
        ];
        return view('accounting.invoices',$data);
    }

    public function sale_filter(Request $request)
    {
        //
        $response = $request->all();

        $sales = ReservationExpenses::leftJoin('reservations','reservations.id','=','reservation_expenses.reservations_id')->select(DB::raw('reservation_expenses.id, reservation_expenses.reservations_id as reservations_id, IFNULL(reservations.grand_total, 0) as grand_total, IFNULL(reservation_expenses.status,reservations.paid) as paid, IFNULL(reservation_expenses.status,reservations.reservation_status) as status, IFNULL(reservation_expenses.method,"View Reservation") as method, reservation_expenses.created_at,reservation_expenses.expense_type,reservation_expenses.description,reservation_expenses.quantity,reservation_expenses.price,reservation_expenses.total_price, IFNULL(reservations.reservation_type,"sale") as reservation_type'));
            // ->where('reservations.reservation_status','confirmed')->orWhere('reservation_expenses.status','paid')
            // ->get()
        if($request->all()){
            $today = false;
            if(isset($response['daterange'])){
                $daterange = explode(" to ",$response['daterange']);
                $firstdate = isset($daterange[0]) ? $daterange[0] : null;
                $seconddate = isset($daterange[1]) ? $daterange[1] : null;
                // dd($firstdate);
                if ($seconddate) {
                    $sales->where('reservation_expenses.created_at', '<=', $seconddate)->where('reservation_expenses.created_at', '>=', $firstdate);
                }else{
                    $sales->where('reservation_expenses.created_at', '<=', date('Y-m-d 23:59:59', strtotime($firstdate)))->where('reservation_expenses.created_at', '>=', $firstdate);
                }
            }

            // dd($response);
            if(isset($response['search'])){
                $search = $response['search'];
                $sales->where(function ($query) use ($search){
                    $query->where('reservation_expenses.description', 'like', '%'.$search.'%')->orWhere('reservation_expenses.expense_type', 'like', '%'.$search.'%')->orWhere('reservation_expenses.method', 'like', '%'.$search.'%')->orWhere('reservations.reservation_type', 'like', '%'.$search.'%');
                });
            }
            if (isset($response['filter_type']) && $response['filter_type'] == 'paid') {
                # code...
                $sales->where(function ($query){
                    $query->where('reservation_expenses.status', 'paid')->orWhere('reservations.paid', 'full');
                });
            }else if (isset($response['filter_type']) && $response['filter_type'] == 'pending') {
                $sales->where(function ($query){
                    $query->where('reservation_expenses.status', 'pending')->orWhere('reservations.paid', 'part')->orWhere('reservations.paid', 'pending');
                });
            }
        }else{
            $sales->where('reservation_expenses.created_at', '<=', date('Y-m-d 23:59:59'))->where('reservation_expenses.created_at', '>=', date('Y-m-d 00:00:00'));
            $today = true;
        }

        $sales = $sales->with('sale_payment')->orderBy('reservation_expenses.created_at','desc')->paginate(200);
        $sales->appends($response);

        $data = [
            'filter' => $response,
            'today' => $today,
            'all_sales' => $sales
        ];
        // dd($data);
        return view('accounting.sales',$data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function other_sales(Request $request)
    {
        //
        $response = $request->all();

        $sales = ReservationExpenses::leftJoin('reservations','reservations.id','=','reservation_expenses.reservations_id')->select(DB::raw('reservation_expenses.id, reservation_expenses.reservations_id as reservations_id, IFNULL(reservations.grand_total, 0) as grand_total, IFNULL(reservation_expenses.status,reservations.paid) as paid, IFNULL(reservation_expenses.status,reservations.reservation_status) as status, IFNULL(reservation_expenses.method,"View Reservation") as method, reservation_expenses.created_at,reservation_expenses.expense_type,reservation_expenses.description,reservation_expenses.quantity,reservation_expenses.price,reservation_expenses.total_price, IFNULL(reservations.reservation_type,"sale") as reservation_type'))->where('reservation_expenses.created_at', '<=', date('Y-m-d 23:59:59'))->where('reservation_expenses.created_at', '>=', date('Y-m-d 00:00:00'));
        $today = true;

        $data = [
            'filter' => $response,
            'today' => $today,
            'all_sales' => $sales->with('sale_payment')
            ->orderBy('reservation_expenses.created_at','desc')
            // ->get()
            ->paginate(200)
        ];
        // dd($data);
        return view('accounting.sales',$data);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sale_store(Request $request)
    {
        //
        // dd($request->all());
        $this->validate($request,[
            'expense_type' => 'required',
            'expense_description' => 'required',
            'expense_quantity' => 'required',
            'expense_price' => 'required',
            'expense_total_price' => 'required',
            'expense_status' => 'required',
            'expense_payment_type' => 'required',
            'expense_received_by' => 'required',
        ]);

        if(strtotime(date('Y-m-d 06:00:00')) >= strtotime($this->todaydatetime()) && strtotime(date('Y-m-d 00:00:00')) < strtotime($this->todaydatetime()) ){
            $setdate = date('Y-m-d 23:59:00', strtotime('-1 days'));
        }else{
            $setdate = $this->todaydatetime();
        }

        // dd($setdate);

        try{
            DB::beginTransaction();
            $sale_id = DB::table('reservation_expenses')->insertGetId([
                'expense_type' => $request->input('expense_type'),
                'description' => $request->input('expense_description'),
                'quantity' => $request->input('expense_quantity'),
                'price' => $request->input('expense_price'),
                'total_price' => $request->input('expense_total_price'),
                'method' => $request->input('expense_payment_type'),
                'status' => $request->input('expense_status'),
                'created_at' => $setdate,
            ]);

            if($request->input('expense_status') == 'paid'){
                DB::table('payments')->insert([
                    'currency' => 'GHS',
                    'provider' => $request->input('expense_payment_type'),
                    'payment_type' => 'sale',
                    'payment_type_id' => $sale_id,
                    'amount' => $request->input('expense_total_price')*100,
                    'reference' => $request->input('expense_reference'),
                    'vat_invoice_number' => $request->input('expense_vat_invoice_number'),
                    'received_by' => $request->input('expense_received_by'),
                    'status' => 'success',
                    'created_at' => $setdate,
                ]);
            }
            DB::commit();

        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return back()->with('error','Could Not Record Sale.');
        }

        return redirect()->route('other.sales')->with('success','Sale Record Saved Successfully');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sale_update(Request $request, $id)
    {
        //
        // dd($request->all());
        $this->validate($request,[
            'expense_type' => 'required',
            'expense_description' => 'required',
            'expense_quantity' => 'required',
            'expense_price' => 'required',
            'expense_total_price' => 'required',
            'expense_status' => 'required',
            'expense_payment_type' => 'required',
        ]);

        $sale = ReservationExpenses::find($id);
        $sale->expense_type = $request->input('expense_type');
        $sale->description = $request->input('expense_description');
        $sale->quantity = $request->input('expense_quantity');
        $sale->price = $request->input('expense_price');
        $sale->total_price = $request->input('expense_total_price');
        $sale->status = $request->input('expense_status');
        $sale->method = $request->input('expense_payment_type');
        $sale->update();

        return redirect()->route('other.sales')->with('success','Sale Record Updated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function show(Accounting $accounting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function edit(Accounting $accounting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Accounting $accounting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Accounting  $accounting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Accounting $accounting)
    {
        //
    }

    public function sale_destroy($id)
    {
        //
        try{
            DB::table('reservation_expenses')->where('id',$id)->delete();
            DB::table('payments')->where('payment_type_id',$id)->where('payment_type','sale')->delete();
            return true;
        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollback();
            return false;
        }
    }
}
