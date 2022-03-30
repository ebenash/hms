<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Session;

class UserController extends CommonController
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
        $data = ['all_users'=> User::where('company_id',auth()->user()->company->id)->get()];
        return view('auth.list',$data);
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'title' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer'],
        ]);


        try{
            DB::beginTransaction();
            $password = $this->generate_password(10);

            $user_id =  DB::table('users')->insertGetId([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'title' => $request->input('title'),
                'role_id' => $request->input('role_id'),
                'password' => Hash::make($password),
                'company_id' => auth()->user()->company->id,
                'created_by' => auth()->user()->id,
            ]);

            DB::table('settings')->insert([
                'created_by' => $user_id,
                'company_id' => auth()->user()->company->id,
            ]);

            $user = User::find($user_id);

            DB::commit();

            //Send Email Password
            Notification::send($user, new NewUserNotification($user,$password));

            Session::has('settings_company') ? Session::forget('settings_company') : '';
            return redirect()->route('settings-tab','users')->with('success','User Successfully Created')->with('settings_users','settings_users');
        }catch(\Exception $e){
            $this->ExceptionHandler($e);
            DB::rollBack();
            return redirect()->route('settings-tab','users')->with('error','Could Not Record User.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::find($id);
        return view('auth.show')->with('profile',$user);
    }

    public function profile()
    {
        //
        $user = User::find(Auth::id());
        return view('auth.show')->with('profile',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'role_id' => ['required', 'integer']
        ]);

        $user = User::find($id);

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->title = $request->input('title');
        $user->role_id = $request->input('role_id');

        $user->update();
        return redirect()->route('settings-tab','users')->with('success','Profile Successfully Updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_password(Request $request, $id)
    {
        //
        $request->validate([
            'password-old' => ['required', 'string', 'min:8', ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::find($id);

        if(Hash::check($request->input('name'), $user->password)){
            return redirect('/user/profile')->with('error','The current password you entered is incorrect.');
        }else{
            $user->password = Hash::make($request->input('password'));

            $user->update();
            return redirect()->route('user-profile')->with('success','Password Successfully Updated.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        return User::find($id)->delete();
    }
}
