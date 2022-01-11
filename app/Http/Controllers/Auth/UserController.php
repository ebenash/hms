<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class UserController extends Controller
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
        return view('auth.list');
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
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        $user = new User;

        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->title = $request->input('title');
        $user->role_id = $request->input('role_id');
        $user->password = Hash::make($request->input('password'));
        $user->company_id = auth()->user()->company->id;
        $user->created_by = auth()->user()->id;

        $user->save();
        return redirect('/users')->with('success','Profile Successfully Updated');
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
        $user = User::find(\Auth::id());
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
        return redirect('/users/'.$id)->with('success','Profile Successfully Updated');
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
            return redirect('/user/profile')->with('success','Password Successfully Updated.');
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
    }
}
