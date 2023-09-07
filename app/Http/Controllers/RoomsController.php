<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Models\RoomTypes;
use Illuminate\Http\Request;

class RoomsController extends Controller
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
            'all_rooms' => Rooms::where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get()
        ];
        return view('rooms.list',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data = [
            'all_rooms' => Rooms::where('company_id',auth()->user()->company->id)->orderBy('name','asc')->get(),
            'all_roomtypes' => RoomTypes::where('company_id',auth()->user()->company->id)->get()
        ];
        return view('rooms.form',$data)->with('create','create');
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
            'name'=>'required',
            'type'=>'required',
            'status'=>'required',
            'bed_type'=>'required'
        ]);

        $room = new Rooms;

        $room->name = $request->input('name');
        $room->room_type_id = $request->input('type');
        $room->status = $request->input('status');
        $room->bed_type = $request->input('bed_type');
        $room->company_id = auth()->user()->company->id;
        $room->created_by = auth()->user()->id;

        $room->save();

        return back()->with('success', 'Room Successfully Saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $room = Rooms::find($id);
        return view('rooms.show')->with('room',$room);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $room = Rooms::find($id);
        return view('rooms.form')->with('room',$room);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $room = Rooms::find($id);

        $this->validate($request,[
            'name'=>'required',
            'type'=>'required',
            'status'=>'required',
            'bed_type'=>'required'
        ]);

        $room->name = $request->input('name');
        $room->room_type_id = $request->input('type');
        $room->status = $request->input('status');
        $room->bed_type = $request->input('bed_type');

        $room->update();

        return back()->with('success','Successfully Updated!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return Rooms::find($id)->delete();
    }


    public function get_rooms($id)
    {
        //
        // dd($id);
        $rooms = Rooms::where('status',1)->where('room_type_id',$id)->get();
        // dd($rooms);
        return response()->json($rooms);
    }

    public function get_available_rooms(Request $request,$id)
    {
        // dd($request->all());
        $notavailable = null;

        $check_in = isset($request->checkin) ? $request->checkin : null;
        $check_out = isset($request->checkout) ? $request->checkout : null;
        // $rooms = Rooms::where('status',1)->where('room_type_id',$id)->get();
        $notavailable = Rooms::join('reservation_details','rooms.id','=','reservation_details.room_id')->join('reservations','reservation_details.reservations_id','=','reservations.id')->where('rooms.status', 1)->where('reservations.reservation_status', 'confirmed')->where('rooms.room_type_id',$id)->select('rooms.*');
        if($notavailable){
            if ($check_out) {
                $notavailable->where('check_in', '<', $check_out)->where('check_out', '>=', $check_in);
            }else{
                $notavailable->where('check_in', '<=', $check_in)->where('check_out', '>=', $check_in);
            }

            $notavailids = array_column($notavailable->get()->toArray(), 'id');
            $available = Rooms::where('rooms.status', 1)->whereNotIn('rooms.id',$notavailids)->where('room_type_id',$id)->get();
            // dd($available);
            return response()->json($available);
        }else{
            $rooms = Rooms::where('status',1)->where('room_type_id',$id)->get();
            // dd($rooms);
            return response()->json($rooms);
        }
        // dd($notavailable->get());
    }
}
