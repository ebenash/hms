<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Settings;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab = null)
    {
        //
        $data = [
            'all_users'=> User::where('company_id',auth()->user()->company->id)->get(),
            'roles'=> DB::table('roles')->select('name')->get()
        ];

        // auth()->user()->roles->first()->givePermissionTo('edit users');
        // dd(auth()->user()->can('edit users'));

        if(!$tab){
             if(auth()->user()->can('edit company')){
                $tab = 'company';
             }else if(auth()->user()->can('view users')){
                $tab = 'users';
             }else{
                $tab = 'theme';
             }
        }
        // dd($data);
        return view('settings',$data)->with('tab',$tab);
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
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        if ($request->update_type == 'company') {
            # code...
            $request->validate([
                'logo' => 'image|nullable'
            ]);


            $company = Company::find($id);

            if($request->hasFile('logo')){
                $rawfilename = $request->file('logo')->getClientOriginalName();
                $filenameonly = pathinfo($rawfilename,PATHINFO_FILENAME);
                $extension = $request->file('logo')->getClientOriginalExtension();
                $filename = $filenameonly."_".time().".".$extension;
                $path = $request->file('logo')->storeAs('public/uploads',$filename);

                if($company->logo != null || $company->logo != "")
                {
                    unlink(storage_path('app/public/uploads/'.$company->logo));
                }
            }else{
                $filename = $company->logo;
            }

            // $company->avatar = $filename;

            $company->name = $request->company_name;
            $company->email = $request->email;
            $company->phone = $request->phone;
            $company->logo = $filename;
            $company->currency = $request->currency;
            $company->location = $request->location;
            $company->website = $request->website;
            $company->description = $request->description;
            $company->update();
        } else {
            $settings = Settings::where('company_id',$id)->get();
        }

        return back()->with('success','Settings Successfully Updated!');
    }

    public function update_theme_setting(Request $request)
    {
        //
        // dd($request->all());
        $settings = Settings::where('created_by',auth()->user()->id)->get()->first();
        if($request->type == 'theme'){
            $settings->theme = $request->value;
        }
        if($request->type == 'sidebar'){
            $settings->sidebar = $request->value;
        }
        if($request->type == 'header'){
            $settings->header = $request->value;
        }
        if($request->type == 'minimize'){
            if ($settings->minimize) {
                $settings->minimize = null;
            } else {
                $settings->minimize = $request->value;
            }
        }
        $settings->save();

        return true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
