<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Guests;
use App\Models\Rooms;
use App\Models\RoomTypes;
use App\Models\Reservations;
use App\Models\ReservationDetails;
use App\Models\HotelNotifications;
use App\Models\Payments;
use App\Models\PaystackInvoices;
use App\Models\HotelNotificationPhones;
use App\Jobs\ExportDataJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewRequestNotification;
use App\Notifications\DailySummaryNotification;
use App\Notifications\GuestPaymentNotification;

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


    public function send_to_frog($contacts,$message,$type)
    {
        $recipients = [];
        // dd($contacts);
        foreach ($contacts as $key => $recipient) {
            $recipients[]=[
                'destination' => $recipient->phone_number,
                'msgid' => date('YmdHis')
            ];
        }


        $postdata = [
            'username' => env("FROG_USER", "username"),
            'password' => env("FROG_PASSWORD", "passsword"),
            'senderid' => env("FROG_SENDERID", "SENDER"),
            'message' => $message,
            'service' => $type,
            'destinations' => $recipients,
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
            $this->writelog("FROG Send API Response: ".json_encode($response)."\n",1);
            // dd($result);
            if ($err) {
                $this->writelog("cURL Error #:"."\n",1);
            }

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

    public function send_admin_notification($reservation_id) {

        $reservation = Reservations::where('id',$reservation_id)->with(['guest'])->first();
        // dd($reservation);
        $hotel_phones = HotelNotificationPhones::select('phone_number')->where('status',1)->get();

        $this->send_to_frog(
            $hotel_phones,
            "A New Reservation Request has been submitted on the ".env('APP_NAME')." website! Please verify and respond.",
            'SMS'
        );
        $users = User::all();
        Notification::send($users, new NewRequestNotification($reservation));
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

            $guests = Guests::where("full_name","like","%".$keyword."%")->orWhere("email","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();
            $rooms = Rooms::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();
            $roomtypes = RoomTypes::where("name","like","%".$keyword."%")->where('company_id',auth()->user()->company->id)->limit($limit)->get();
            // $ressearch = Reservations::find($keyword);
            // dd($ressearch);
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
                $details = ReservationDetails::whereIn("room_id",array_column($rooms->toArray(), 'id'))->get();
                if ($first) {
                    $reservations->whereIn("id",array_column($details->toArray(), 'reservations_id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("id",array_column($details->toArray(), 'reservations_id'));
                }
                $no_filter = false;
            }
            if (count($roomtypes) > 0) {
                $details = ReservationDetails::whereIn("room_type_id",array_column($roomtypes->toArray(), 'id'))->get();
                if ($first) {
                    $reservations->whereIn("id",array_column($details->toArray(), 'reservations_id'));
                    $first = false;
                } else {
                    $reservations->orWhereIn("id",array_column($details->toArray(), 'reservations_id'));
                }
                $no_filter = false;
            }

            if($no_filter){
                $reservations->where('id',-1);
            }

            $reservations->orWhere('id',$keyword);
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

    public function createNewPaystackCustomer($guest){
        $url = "https://api.paystack.co/customer";

        $guestname = explode(' ',$guest->full_name);
        // dd($guest);
        $fields = [
            "email" => $guest->email,
            "first_name" => $guestname[0],
            "last_name" => $guestname[1] ?? '',
        ];
        // dd(json_encode($fields));
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
        $err = curl_error($ch);
        curl_close($ch);

        $this->writelog("Paystack Customer Create API Response: ".json_encode($result)."\n",1);
        // dd($result);
        if ($err) {
            $this->writelog("cURL Error #:"."\n",1);
        }

        if ($result) {
            if ($result->status) {
                $guest->paystack_identifier = $result->data->id;
                $guest->update();
                return $result->data->id;
            }
            return false;
        }
        return false;
    }
    public function getNewPaystackCustomerCode($guest){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/customer/".$guest->email,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".env('PAYSTACK_SK'),
                "Cache-Control: no-cache",
            ),
        ));



        //execute post
        $result = json_decode(curl_exec($curl));
        $err = curl_error($curl);
        curl_close($curl);

        $this->writelog("Paystack Customer Create API Response: ".json_encode($result)."\n",1);
        // dd($result);
        if ($err) {
            $this->writelog("cURL Error #:"."\n",1);
        }

        if ($result) {
            if ($result->status) {
                $guest->paystack_identifier = $result->data->id;
                $guest->update();
                return $result->data->id;
            }else{
                if ($result->message = "Customer not found"){
                    $customersaved = $this->createNewPaystackCustomer($guest);
                    return $customersaved;
                }
            }
            return false;
        }
        return false;

    }

    public function sendPayStackInvoiceApi($customer,$note, $line_items,$grand_total,$tax,$due_date,$reservation_id=null){

        $url = "https://api.paystack.co/paymentrequest";

        $fields = [
            'description' => $note,
            'line_items' => $line_items,
            // 'tax' => $tax = [
            //     [
            //         'name' => "VAT",
            //         'amount' => number_format((($tax ?? 0)*100),0,'.',''),
            //     ]
            // ],
            'currency' => "GHS",
            'customer' => $customer,
            'due_date' => $due_date,
        ];
        // dd(json_encode($fields));
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

        $this->writelog("Paystack Invoice API Response: ".json_encode($result)."\n",1);
        // dd($result);
        if ($result) {
            if ($result->status) {
                try {
                    DB::beginTransaction();
                    DB::table('paystack_invoices')->insert([
                        'currency' => $result->data->currency,
                        'status' =>  $result->data->status,
                        'paid' =>  $result->data->paid,
                        'reservation_id' => $reservation_id ?? null,
                        'amount' => $grand_total*100,
                        'line_items' => json_encode($result->data->line_items),
                        'tax' => json_encode($result->data->tax),
                        'customer' => $customer,
                        'due_date' => $due_date,
                        'invoice_id' => $result->data->id,
                        'invoice_number' => $result->data->invoice_number,
                        'discount' => $result->data->discount,
                        'request_code' => $result->data->request_code,
                        'offline_reference' => $result->data->offline_reference,
                        'metadata' => $result->data->metadata,
                        'split_code' => $result->data->split_code,
                        'domain' => $result->data->domain,
                        'integration' => $result->data->integration,
                        'created_at' => $this->todaydatetime(),
                    ]);
                    if($reservation_id){
                        DB::table('reservations')->where('id',$reservation_id)->update(['invoice_sent'=> true]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    $this->ExceptionHandler($e);
                    return false;
                }
                return true;
            }else{
                return false;
            }
        }
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
                    'amount' => number_format(($reservation->grand_total*100),0,'.','')
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
                                'amount' => $reservation->grand_total*100,
                                'requested_amount' => $reservation->grand_total*100,
                                'authorization_url' => $result->data->authorization_url,
                                'access_code' => $result->data->access_code,
                                'reference' => $result->data->reference,
                                'created_at' => $this->todaydatetime(),
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

    public function verifyPaystackInvoicesPaid($invoice){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/paymentrequest/".$invoice->request_code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer ".env('PAYSTACK_SK'),
                "Cache-Control: no-cache",
            ),
        ));



        //execute post
        $result = json_decode(curl_exec($curl));
        $err = curl_error($curl);
        curl_close($curl);

        $this->writelog("Paystack Verify Invoice API Response: ".json_encode($result)."\n",1);
        // dd($result);
        if ($err) {
            $this->writelog("cURL Error #:"."\n",1);
        }

        if ($result) {
            if ($result->status) {
                $invoice->status =  $result->data->status;
                $invoice->paid =  $result->data->paid;
                $invoice->paid_at =  $result->data->paid_at;
                $invoice->updated_at = $this->todaydatetime();
                $invoice->update();

                if ($result->data->paid) {
                    DB::table('reservations')->where('id',$invoice->reservation_id)->update([
                        'reservation_status' => 'confirmed'
                    ]);
                }
                return true;
            }
            return false;
        }
        return false;

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
                        'updated_at' => $this->todaydatetime(),
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

    public function payStackWebhook(Request $request)
    {

        try{
            // only a post with paystack signature header gets our attention

            if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) )

            exit();

            // Retrieve the request's body

            $input = @file_get_contents("php://input");
            $this->writelog("Paystack Webhook Payload: ".($input)."\n",1);

            define('PAYSTACK_SECRET_KEY',env('PAYSTACK_SK'));

            // validate event do all at once to avoid timing attack

            if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY))

            exit();

            http_response_code(200);

            // parse event (which is json string) as object

            // Do something - that will not take long - with $event

            $event = json_decode($input);


            if($event->event == "paymentrequest.success"){
                $invoice = PaystackInvoices::where('request_code',$event->data->request_code)->first();
                // dd($invoice);
                if ($invoice) {
                    $invoice->status =  $event->data->status;
                    $invoice->paid =  $event->data->paid;
                    $invoice->paid_at =  $event->data->paid_at;
                    $invoice->updated_at = $this->todaydatetime();
                    $invoice->update();

                    if ($event->data->paid) {
                        DB::table('reservations')->where('id',$invoice->reservation_id)->update([
                            'reservation_status' => 'confirmed',
                            'paid' => 'full',
                            'amount_paid' => (($event->data->amount ?? 0)/100),
                            'balance' => 0,
                        ]);
                        $reservation = Reservations::where('id',$invoice->reservation_id)->with('guest')->first();
                        Notification::route('mail', $reservation->guest->email)->notify(new GuestPaymentNotification($reservation));
                    }
                }
                $smstext = "A Payment has been made for Invoice #".($event->data->invoice_number ?? "Undefined")." on Paystack. Invoice Amount: GHS ".(($event->data->amount ?? 0)/100).".";
            }else if($event->event == "charge.success"){
                $smstext = "A new payment has been made on Paystack. reference:".($event->data->reference ?? "Undefined").". Amount Paid: GHS ".(($event->data->amount ?? 0)/100).". Paid By: ".($event->data->customer->first_name ?? "Undefined")." ".($event->data->customer->last_name ?? "Undefined")." at ".($event->data->paid_at ?? "Undefined").".";
            }else if($event->event == "paymentrequest.pending"){
                $smstext = "New Invoice #".($event->data->invoice_number ?? "Undefined")." has been submitted to a customer and is pending payment.";
            }else{
                $smstext = null;
            }

            $hotel_phones = HotelNotificationPhones::select('phone_number')->where('status',1)->get();

            if($smstext){
                $this->send_to_frog(
                    $hotel_phones,
                    $smstext,
                    'SMS'
                );
            }

            return array("code" => 200, "message"=> "MESSAGE ACCEPTED", "result"=> []);
        }catch(\Exception $e){
            DB::rollBack();
            $this->ExceptionHandler($e);
            return array("code" => 400, "message"=> "MESSAGE REJECTED", "result"=> []);
        }
    }

    public function todaydatetime()
    {
        return date('Y-m-d H:i:s');
    }


    public function checkIfInvoicesArePaid()
    {
        $lastchecklog = storage_path('logs/invoicelastcheck.log');
        // file_exists($lastchecklog);
        if(file_exists($lastchecklog)){
            $lastcheck = file_get_contents($lastchecklog);
            // dd($lastcheck);
            //5 minutes = 300

            $preferred_gap = 300;
            $time_gap = strtotime($this->todaydatetime()) - strtotime($lastcheck);
            // dd($time_gap);
            if ($time_gap > $preferred_gap) {
                $runcheck = true;
            }else{
                $runcheck = false;
            }
        }else{
            $runcheck = true;
        }
        // dd($runcheck);
        if($runcheck){
            $invoices = PaystackInvoices::where('paid',false)->where('status','pending')->whereNotNull('reservation_id')->where('due_date','>=',date("Y-m-d"))->get();
            // dd($invoices);
            foreach ($invoices as $key => $invoice) {
                $this->verifyPaystackInvoicesPaid($invoice);
            }
            file_put_contents($lastchecklog, $this->todaydatetime());
        }
    }


    public function send_daily_admin_report()
    {
        //

        $yesterdays_reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','reservations.vat_invoice_number')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','=',date("Y-m-d",strtotime("-1 day")))->with('details')->orderBy('reservations.check_in','asc')->get();
        $yesterdays_reservation_details = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->join('rooms','reservation_details.room_id','=','rooms.id')->join('room_types','room_types.id','=','rooms.room_type_id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as room_name','reservation_details.price_per_day','room_types.name as room_type')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','=',date("Y-m-d",strtotime("-1 day")))->orderBy('reservations.check_in','asc')->get();

        $stay_over_reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','reservations.vat_invoice_number')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','<=',date("Y-m-d"))->where('reservations.check_out','>',date("Y-m-d"))->with('details')->orderBy('reservations.check_in','asc')->get();
        $stay_over_reservation_details = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->join('rooms','reservation_details.room_id','=','rooms.id')->join('room_types','room_types.id','=','rooms.room_type_id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as room_name','reservation_details.price_per_day','room_types.name as room_type')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','<=',date("Y-m-d"))->where('reservations.check_out','>',date("Y-m-d"))->orderBy('reservations.check_in','asc')->get();

        $checking_in_reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','reservations.vat_invoice_number')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','=',date("Y-m-d"))->with('details')->orderBy('reservations.check_in','asc')->get();
        $checking_in_reservation_details = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->join('rooms','reservation_details.room_id','=','rooms.id')->join('room_types','room_types.id','=','rooms.room_type_id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as room_name','reservation_details.price_per_day','room_types.name as room_type')->where('reservations.reservation_status','confirmed')->where('reservations.check_in','=',date("Y-m-d"))->orderBy('reservations.check_in','asc')->get();
        // dd($stay_over_reservations);

        $checking_out_reservations = Reservations::join('guests','reservations.guest_id','=','guests.id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','reservations.vat_invoice_number')->where('reservations.reservation_status','confirmed')->where('reservations.check_out','=',date("Y-m-d"))->with('details')->orderBy('reservations.check_in','asc')->get();
        $checking_out_reservation_details = DB::table('reservations')->join('guests','reservations.guest_id','=','guests.id')->join('reservation_details','reservations.id','=','reservation_details.reservations_id')->join('rooms','reservation_details.room_id','=','rooms.id')->join('room_types','room_types.id','=','rooms.room_type_id')->select('reservations.id','reservations.check_in', 'reservations.check_out', 'reservations.days', 'reservations.paid', 'reservations.reservation_status', 'reservations.grand_total', 'reservations.amount_paid', 'reservations.balance', 'reservations.payment_method', 'reservations.created_by', 'guests.full_name','rooms.name as room_name','reservation_details.price_per_day','room_types.name as room_type')->where('reservations.reservation_status','confirmed')->where('reservations.check_out','=',date("Y-m-d"))->orderBy('reservations.check_in','asc')->get();
        // dd($reservation_details);

        $yesterdays_res_count=0;
        $yesterdays_detail_count=0;
        $stay_over_res_count=0;
        $stay_over_detail_count=0;
        $checking_in_res_count=0;
        $checking_in_detail_count=0;
        $checking_out_res_count=0;
        $checking_out_detail_count=0;

        $yesterdays_res_body="";
        $yesterdays_detail_body="";
        $stay_over_res_body="";
        $stay_over_detail_body="";
        $checking_in_res_body="";
        $checking_in_detail_body="";
        $checking_out_res_body="";
        $checking_out_detail_body="";

        foreach($yesterdays_reservations as $reservation){
            $yesterdays_res_body.="<tr><td>".($yesterdays_res_count+1)."</td><td>".($reservation->full_name ?? "")."</td><td>".($reservation->details->count() ?? 0)."</td><td>".($reservation->days ?? 0)."</td><td>".ucfirst($reservation->payment_method ?? "Undefined")."</td><td>GHS ".(number_format($reservation->grand_total,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->amount_paid,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->balance,2) ?? 0.00)."</td><td>".($reservation->vat_invoice_number ?? "Undefined")."</td></tr>";
            $yesterdays_res_count++;
        }
        foreach($yesterdays_reservation_details as $detail){
            $yesterdays_detail_body.="<tr><td>".($yesterdays_detail_count+1)."</td><td>".($detail->full_name ?? "")."</td><td>".($detail->room_type ?? "Undefined")."</td><td>".($detail->room_name ?? "Undefined")."</td><td>GHS ".(number_format(($detail->price_per_day*$detail->days),2) ?? 0.00)."</td></tr>";
            $yesterdays_detail_count++;
        }

        foreach($stay_over_reservations as $reservation){
            $stay_over_res_body.="<tr><td>".($stay_over_res_count+1)."</td><td>".($reservation->full_name ?? "")."</td><td>".($reservation->details->count() ?? 0)."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td><td>GHS ".(number_format($reservation->amount_paid,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->balance,2) ?? 0.00)."</td></tr>";
            $stay_over_res_count++;
        }
        foreach($stay_over_reservation_details as $detail){
            $stay_over_detail_body.="<tr><td>".($stay_over_detail_count+1)."</td><td>".($detail->full_name ?? "")."</td><td>".($detail->room_type ?? "Undefined")."</td><td>".($detail->room_name ?? "Undefined")."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td></tr>";
            $stay_over_detail_count++;
        }

        foreach($checking_in_reservations as $reservation){
            $checking_in_res_body.="<tr><td>".($checking_in_res_count+1)."</td><td>".($reservation->full_name ?? "")."</td><td>".($reservation->details->count() ?? 0)."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td><td>".ucfirst($reservation->payment_method ?? "Undefined")."</td><td>GHS ".(number_format($reservation->grand_total,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->amount_paid,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->balance,2) ?? 0.00)."</td></tr>";
            $checking_in_res_count++;
        }
        foreach($checking_in_reservation_details as $detail){
            $checking_in_detail_body.="<tr><td>".($checking_in_detail_count+1)."</td><td>".($detail->full_name ?? "")."</td><td>".($detail->room_type ?? "Undefined")."</td><td>".($detail->room_name ?? "Undefined")."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td><td>GHS ".(number_format(($detail->price_per_day*$detail->days),2) ?? 0.00)."</td></tr>";
            $checking_in_detail_count++;
        }

        foreach($checking_out_reservations as $reservation){
            $checking_out_res_body.="<tr><td>".($checking_out_res_count+1)."</td><td>".($reservation->full_name ?? "")."</td><td>".($reservation->details->count() ?? 0)."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td><td>".ucfirst($reservation->payment_method ?? "Undefined")."</td><td>GHS ".(number_format($reservation->grand_total,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->amount_paid,2) ?? 0.00)."</td><td>GHS ".(number_format($reservation->balance,2) ?? 0.00)."</td></tr>";
            $checking_out_res_count++;
        }
        foreach($checking_out_reservation_details as $detail){
            $checking_out_detail_body.="<tr><td>".($checking_out_detail_count+1)."</td><td>".($detail->full_name ?? "")."</td><td>".($detail->room_type ?? "Undefined")."</td><td>".($detail->room_name ?? "Undefined")."</td><td>".($reservation->check_in ?? "Undefined")."</td><td>".($reservation->check_out ?? "Undefined")."</td><td>GHS ".(number_format(($detail->price_per_day*$detail->days),2) ?? 0.00)."</td></tr>";
            $checking_out_detail_count++;
        }

        $summary = array();
        $summary['yesterdays_res_body'] = $yesterdays_res_body;
        $summary['yesterdays_res_count'] = $yesterdays_res_count;
        $summary['yesterdays_detail_body'] = $yesterdays_detail_body;
        $summary['yesterdays_detail_count'] = $yesterdays_detail_count;

        $summary['stay_over_res_body'] = $stay_over_res_body;
        $summary['stay_over_res_count'] = $stay_over_res_count;
        $summary['stay_over_detail_body'] = $stay_over_detail_body;
        $summary['stay_over_detail_count'] = $stay_over_detail_count;

        $summary['checking_in_res_body'] = $checking_in_res_body;
        $summary['checking_in_res_count'] = $checking_in_res_count;
        $summary['checking_in_detail_body'] = $checking_in_detail_body;
        $summary['checking_in_detail_count'] = $checking_in_detail_count;

        $summary['checking_out_res_body'] = $checking_out_res_body;
        $summary['checking_out_res_count'] = $checking_out_res_count;
        $summary['checking_out_detail_body'] = $checking_out_detail_body;
        $summary['checking_out_detail_count'] = $checking_out_detail_count;

        // dd($summary);
        if($summary){
            $users = User::all();
            try{
                Notification::send($users, new DailySummaryNotification($this->objectify($summary)));
            } catch (\Exception $e) {
                $this->ExceptionHandler($e);
            }
            return "true";
        }else{
            return "false";
        }
    }

}
