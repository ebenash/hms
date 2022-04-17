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
use App\Models\Payments;
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

    public function takeActionHandler($notice)
    {
        $postcontents = @file_get_contents('php://input');
        $actiondata = $notice.PHP_EOL;
        $actiondata.= 'Post Request Details:=> '.PHP_EOL.$postcontents;

        $this->writelog($actiondata);
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

    public function send_admin_notification() {
        // $all_users= User::where('company_id',Company::find(1)->id)->get();

        // foreach ($all_users as $key => $user) {
            # code...
            // $main_company = Company::find(1);
            Notification::route('mail', env('HOTEL_MAIN_EMAIL'))->notify(new NewRequestNotification());
            $this->send_to_frog(
                // $user->phone,
                env('HOTEL_MAIN_PHONE'),
                "Hello Admin!\n\nA New Reservation Request has been submitted on ".env('APP_NAME')."!\nPlease verify and approve/reject. \n\nAutomated message from ".env('APP_NAME').".",
                'SMS'
            );
        // }
    }

    public function hotel_notification( $message, $type, $url ) {
        $notification = new HotelNotifications;
        $notification->message = $message;
        $notification->type = $type;
        $notification->date = date('Y-m-d H:i:s');
        $notification->status = 'unread';
        $notification->url = $url;
        $notification->save();

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
        $no_filter = true;
        $limit = 5000;

        if(isset($request->keyword)){
            $keyword = $request->keyword;

            $guests = Guests::where("full_name","like","%".$keyword."%")->orWhere("phone","like","%".$keyword."%")->orWhere("email","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();
            $rooms = Rooms::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();
            $roomtypes = RoomTypes::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();

            $first = true;

            if (count($guests) > 0) {
                if ($first) {
                    $reservations->whereIn("guest_id",array_column($guests->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("guest_id",array_column($guests->toArray(), 'id'));
                }
                $no_filter = false;
            }
            if (count($rooms) > 0) {
                if ($first) {
                    $reservations->whereIn("room_id",array_column($rooms->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("room_id",array_column($rooms->toArray(), 'id'));
                }
                $no_filter = false;
            }
            if (count($roomtypes) > 0) {
                if ($first) {
                    $reservations->whereIn("room_type",array_column($roomtypes->toArray(), 'id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("room_type",array_column($roomtypes->toArray(), 'id'));
                }
                $no_filter = false;
            }

            $reservations->with(['roomtype','room']);
        }

        if($no_filter){
            $reservations->where('id',-1);
        }

        $data = [
            'search_guests' => $guests ?? [],
            'search_rooms' => $rooms ?? [],
            'search_roomtypes' => $roomtypes ?? [],
            'search_reservations' => $reservations->limit($limit)->get() ?? [],
            'keyword' => $request->keyword ?? ''
        ];
        // dd($data);
        return view('search',$data);
    }

    public function objectify(Array $array)
    {
        return json_decode(json_encode($array));
    }

    //Mobile Format Function
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

    public function payStackPaymentApi(Request $request,$reservation_id){
        $reservation = Reservations::find($reservation_id);
        $roomtype = RoomTypes::find($reservation->room_type);
        if($reservation){
            $oldpayment = Payments::where('reservation_id',$reservation_id)->where('created_at','>=',date('Y-m-d H:i:s', strtotime('-1 days')))->first();
            if($oldpayment){
                return redirect($oldpayment->authorization_url);
            }else{
                $url = "https://api.paystack.co/transaction/initialize";
                $fields = [
                    'email' => $reservation->guest->email,
                    'currency' => $reservation->currency,
                    'amount' => number_format(($reservation->price*100),0,'.','')
                ];
                // dd($fields);
                $fields_string = http_build_query($fields);
                //open connection
                $ch = curl_init();

                //set the url, number of POST vars, POST data
                curl_setopt($ch,CURLOPT_URL, $url);
                curl_setopt($ch,CURLOPT_POST, true);
                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Authorization: Bearer ".env('PAYSTACK_SK'),
                "Cache-Control: no-cache",
                ));

                //So that curl_exec returns the contents of the cURL; rather than echoing it
                curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

                //execute post
                $result = json_decode(curl_exec($ch));

                $this->writelog("Paystack Transaction API Response: ".json_encode($result)."\n",1);
                // dd($result);
                if ($result) {
                    if ($result->status) {
                        try {
                            DB::beginTransaction();
                            DB::table('payments')->insert([
                                'currency' => $reservation->currency,
                                'provider' => 'paystack',
                                'reservation_id' => $reservation->id,
                                'amount' => $reservation->price*100,
                                'requested_amount' => $reservation->price*100,
                                'authorization_url' => $result->data->authorization_url,
                                'access_code' => $result->data->access_code,
                                'reference' => $result->data->reference,
                                'created_at' => date('Y-m-d H:i:s'),
                            ]);
                            DB::commit();
                        } catch (\Exception $e) {
                            DB::rollBack();
                            $this->ExceptionHandler($e);
                            return redirect()->route('home.roomdetails',$roomtype->name)->with('error','There was an error redirecting to the payment page. Please try again.');
                        }
                        return redirect($result->data->authorization_url);
                    }
                    $this->takeActionHandler("PayStack Response Error: ".json_encode($result));
                    // session()->put('success','There was an error redirecting to the payment page. Please try again.');
                    return redirect()->route('home.roomdetails',$roomtype->name)->with('success','There was an error redirecting to the payment page. Please try again.');
                }
                $this->takeActionHandler("PayStack Response Error: ".json_encode($result));
                return redirect()->route('home.roomdetails',$roomtype->name)->with('error','There was an error redirecting to the payment page. Please try again.');
            }
        }
        $this->takeActionHandler("PayStack Response Error: Reservation ID: ".$reservation_id." does not exist");
        return redirect()->route('home.rooms')->with('error','There was an error redirecting to the payment page. Please try again.');
    }

    public function payStackCallback(Request $request)
    {
        //
        $this->writelog("Paystack Callback Payload: ".json_encode($request->all())."\n",1);
        try{
            $callback_results = $this->objectify($request->all());

            if($callback_results->status){
                $payment = Payments::select('id','reservation_id')->where('reference',$callback_results->data->reference)->first();

                // dd($payment);
                if($payment){
                    DB::beginTransaction();

                    DB::table('payments')->where('id',$payment->id)->update([
                        'transaction_date' => $callback_results->data->transaction_date,
                        'status' => $callback_results->data->status,
                        'domain' => $callback_results->data->domain,
                        'gateway_response' => $callback_results->data->gateway_response,
                        'message' => $callback_results->data->message,
                        'channel' => $callback_results->data->channel,
                        'ip_address' => $callback_results->data->ip_address,
                        'log' => json_encode($callback_results->data->log),
                        'authorization' => json_encode($callback_results->data->authorization),
                        'customer' => json_encode($callback_results->data->customer),
                        'fees' => $callback_results->data->fees,
                        'plan' => $callback_results->data->plan,
                        'requested_amount' => $callback_results->data->requested_amount,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

                    if ($callback_results->data->status == "success") {
                        DB::table('reservations')->where('id',$payment->reservation_id)->update([
                            'reservation_status' => 'confirmed'
                        ]);
                    }

                    DB::commit();
                }
            }

            return array("code" => 200, "message"=> "MESSAGE ACCEPTED", "result"=> []);
        }catch(\Exception $e){
            DB::rollBack();
            $this->ExceptionHandler($e);
            return array("code" => 400, "message"=> "MESSAGE REJECTED", "result"=> []);
        }
    }

}
