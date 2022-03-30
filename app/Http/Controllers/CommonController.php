<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\RoomTypes;
use App\Models\Reservations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HotelNotifications;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewRequestNotification;

// use Illuminate\Support\Facades\DB;

class CommonController extends Controller
{
    public function mysqli_connection()
    {
        $DB_Type = env("DB_CONNECTION", "mysql");
        $DB_Host = env("DB_HOST", "localhost"); //set DB Host IP
        $DB_Name = env("DB_DATABASE", "rehms"); //set DB Name
        $DB_User = env("DB_USERNAME", "root"); //set DB User Name
        $DB_Pass = env("DB_PASSWORD", ""); //set DB Password
        date_default_timezone_set("Africa/Accra");

        $con = @mysqli_connect($DB_Host,$DB_User,$DB_Pass,$DB_Name) or die("could not connect to mysql");
        return $con;
    }

    public function mysqli_fetch($sql){

        $localcon=$this->mysqli_connection();
        $result = mysqli_query($localcon,$sql);
        $result_array = null;
        if($result){
            if(mysqli_num_rows($result) == 1)
            {
                $result_array = json_decode(json_encode(current(mysqli_fetch_all($result,MYSQLI_ASSOC))));
                mysqli_close($localcon);
                return $result_array;
            }else if(mysqli_num_rows($result) > 1)
            {
                $result_array = json_decode(json_encode(mysqli_fetch_all($result,MYSQLI_ASSOC)));
                mysqli_close($localcon);
                return $result_array;
            }
        }
        mysqli_close($localcon);
        return $result_array;
    }

    public function mysqli_fetch_normal($sql){

        $localcon=$this->mysqli_connection();
        $result = mysqli_query($localcon,$sql);
        $result_array = null;
        if($result){
            $result_array = json_decode(json_encode(mysqli_fetch_all($result,MYSQLI_ASSOC)));
            mysqli_close($localcon);
            return $result_array;
        }
        mysqli_close($localcon);
        return $result_array;
    }

    public function mysqli_fetch_array($sql){

        $localcon=$this->mysqli_connection();
        $result = mysqli_query($localcon,$sql);
        $result_array = null;
        if($result){
            $result_array = mysqli_fetch_all($result,MYSQLI_ASSOC);
            mysqli_close($localcon);
            return $result_array;
        }
        mysqli_close($localcon);
        return $result_array;
    }

    public function mysqli_insert($sql){

        $localcon=$this->mysqli_connection();
        $result = mysqli_query($localcon,$sql);
        mysqli_close($localcon);
        return $result;
    }

    public function mysqli_multi_text($sql){
        $localcon=$this->mysqli_connection();
        $result = mysqli_multi_query($localcon,$sql);
        mysqli_close($localcon);
        return $result;
    }
    public function mysqli_multi_array($sql_arr){
        $localcon=$this->mysqli_connection();
        mysqli_query($localcon,"SET autocommit=0");
        $results = array();
        foreach($sql_arr as $sql){
            $results[] = mysqli_query($localcon,$sql);
        }
        if(!in_array(false, $results)){
            $result = mysqli_query($localcon,"COMMIT");
        }else{
            $result = false;
        }
        mysqli_query($localcon,"SET autocommit=1");
        mysqli_close($localcon);
        return $result;
    }

    // public function validateToken($token)
    // {
    //     $apikey = ApiKey::where('apikey', $token)->first();

    //     if(!$apikey)
    //     {
    //         return false;
    //     }

    //     return true;
    // }

    public function writelog($data,$append=TRUE)
    {
        if(env('ENABLE_LOGGING','YES') == 'YES')
        {
            $logfile = storage_path('logs/hmslog-'.date("Y-m-d").'.log');
            if($append)
            {
                    file_put_contents($logfile,"\n".date('Y-m-d H:i:s').": \t".$data,FILE_APPEND);
            }
            else
            {
                file_put_contents($logfile,"\n".date('Y-m-d H:i:s').": \t".$data);
            }

        }
    }

    public function ExceptionHandler($ex)
    {
        $postcontents = @file_get_contents('php://input');
        $errordata = $ex->getMessage().PHP_EOL;
        $errordata.= $ex->getTraceAsString().PHP_EOL;
        $errordata.= 'Thrown in ' . $ex->getFile() . ' on line ' . $ex->getLine().PHP_EOL;
        $errordata.= 'Post Request Details:=> '.PHP_EOL.$postcontents;

        $this->writelog($errordata);
    }


    public function paginate($items, $perPage)
    {
        $pageStart           = request('page', 1);
        $offSet              = ($pageStart * $perPage) - $perPage;
        $itemsForCurrentPage = array_slice($items, $offSet, $perPage, TRUE);

        return new LengthAwarePaginator(
            $itemsForCurrentPage, count($items), $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );
    }


    public function send_to_frog($recipient,$message,$type)
    {
        $postdata = [
            'username' => env("FROG_USER", "username"),
            'password' => env("FROG_PASSWORD", "passsword"),
            'senderid' => env("FROG_SENDERID", "SENDER"),
            'message' => $message,
            'service' => $type,
            'destinations' => [
                [
                    'destination' => $recipient,
                    'msgid' => date('YmdHis')
                ]
            ]
        ];
        // dd($postdata);

        if($postdata){

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://frog.wigal.com.gh/api/v2/sendmsg",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($postdata),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/json"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            $response = json_decode($response);
            if(!$err || $err=="") {
                if($response->status == 'ACCEPTED'){
                    return true;
                }else{
                    return false;
                }
            }else {
                return false;
            }
        }
    }

    public function generate_password( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    public function hotel_notification( $message, $type, $url ) {
        $notification = new HotelNotifications;
        $notification->message = $message;
        $notification->type = $type;
        $notification->date = date('Y-m-d H:i:s');
        $notification->status = 'unread';
        $notification->url = $url;
        $notification->save();

        $all_users= User::where('company_id',Company::find(1)->id)->get();

        foreach ($all_users as $key => $user) {
            # code...
            // Notification::send($user, new NewRequestNotification($user));
            $this->send_to_frog(
                $user->phone,
                "Hello ".$user->name."!\nA New Reservation Request has been submitted on ".$user->company->name."!\nPlease verify and approve/reject. \n\nAutomated message from ".$user->company->name.".",
                'SMS'
            );
        }

        return $notification;
    }
    public function notifications_unread( Request $request ) {
        DB::table('hotel_notifications')->where('status','unread')->update([
            'status' => 'read'
        ]);
        return back()->with('success','Notification Statuses Successfully Updated!');
    }
    public function handle_notification( Request $request, $id ) {
        DB::table('hotel_notifications')->where('id',$id)->update([
            'status' => 'read'
        ]);
        return redirect($request->url);
    }

    public function global_search(Request $request)
    {
        //
        $reservations = Reservations::orderBy('created_at','desc')->where('company_id',auth()->user()->company->id);
        $nofilter = true;

        if(isset($request->keyword)){
            $keyword = $request->keyword;

            $guests = Guests::where("full_name","like","%".$keyword."%")->orWhere("phone","like","%".$keyword."%")->orWhere("email","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->get();
            $rooms = Rooms::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->get();
            $roomtypes = RoomTypes::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->get();

            $first = true;

            if (count($guests) > 0) {
                if ($first) {
                    $reservations->whereIn("guest_id",array_column($guests->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("guest_id",array_column($guests->toArray(), 'id'));
                }
                $nofilter = false;
            }
            if (count($rooms) > 0) {
                if ($first) {
                    $reservations->whereIn("room_id",array_column($rooms->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("room_id",array_column($rooms->toArray(), 'id'));
                }
                $nofilter = false;
            }
            if (count($roomtypes) > 0) {
                if ($first) {
                    $reservations->whereIn("room_type",array_column($roomtypes->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("room_type",array_column($roomtypes->toArray(), 'id'));
                }
                $nofilter = false;
            }

            $reservations->with(['roomtype','room']);
        }

        if($nofilter){
            $reservations->where('id',-1);
        }

        $data = [
            'search_guests' => $guests ?? [],
            'search_rooms' => $rooms ?? [],
            'search_roomtypes' => $roomtypes ?? [],
            'search_reservations' => $reservations->get() ?? [],
            'keyword' => $request->keyword ?? ''
        ];
        // dd($data);
        return view('search',$data);
    }

    public function objectify(Array $array)
    {
        return json_decode(json_encode($array));
    }

    //Mobile Format Fuction
    public function formatphonenumber($phone,$code=null)
    {
        //Remove any parentheses and the numbers they contain:
        // $phone = preg_replace("/\([0-9]+?\)/", "", $phone);

        //Strip spaces and non-numeric characters:
        $phone = preg_replace("/[^0-9]/", "", $phone);

        //Strip out leading zeros:
        $phone = ltrim($phone, '0');

        //Set default country code if the none is provided:
        if (!$code){
            $code = '233';
        }

        //Check if the number doesn't already start with the correct dialling code:
        if ( !preg_match('/^'.$code.'/', $phone)  ) {
            if(strlen($phone) < 10){
                //check if length is large enough
                $phone = $code.$phone;
            }
        }else{
            if(strlen($phone) < 10){
                //check if length is large enough
                $phone = $code.$phone;
            }
        }
        return $phone;
    }

}
