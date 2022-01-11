@extends('layouts.app')
@section('content')
<div class="block">
    <ul class="nav nav-tabs nav-tabs-alt nav-justified" data-toggle="tabs">
        <li class="active">
            <a href="#btabs-alt-static-justified-information"><i class="fa fa-cog"></i>Company Information</a>
        </li>
        <li class="active">
            <a href="#btabs-alt-static-justified-settings"><i class="fa fa-cog"></i>General Settings</a>
        </li>
        <li class="">
            <a href="#btabs-alt-static-justified-home"><i class="fa fa-home"></i> Home</a>
        </li>
        <li class="">
            <a href="#btabs-alt-static-justified-profile"><i class="fa fa-pencil"></i> Profile</a>
        </li>
    </ul>
    <div class="block-content tab-content">
        <div class="tab-pane active" id="btabs-alt-static-justified-information">
            <h4 class="font-w300 push-15">Settings</h4>
            <div class="block-content">
                <form class="form-horizontal push-10-t push-10" action="base_forms_premade.html" method="post" onsubmit="return false;">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <div class="form-material">
                                <input class="form-control" type="text" id="company_name" name="company_name" value="{{$current_user->company->name}}">
                                <label for="company_name">Company Name</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="form-material input-group floating">
                                <input class="form-control" type="email" id="email" name="email" value="{{$current_user->company->email}}">
                                <label for="email">Email</label>
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-material input-group floating">
                                <input class="form-control" type="tel" id="phone" name="phone" value="{{$current_user->company->phone}}">
                                <label for="phone">Phone</label>
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <label for="phone">Company Logo</label>
                            <div class="form-material input-group floating">
                                <div>
                                    <span class="">
                                        <input type="file" name="logo" class="btn btn-primary form-control" aria-invalid="false">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                             <label for="phone">Current Logo</label>
                            <div class="form-material input-group floating">
                                <div class="thumbnail" style="width: 200px; height: 70px;"><img src="storage/uploads/{{$current_user->company->logo}}"/></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-6">
                            <div class="form-material input-group floating">
                                <input class="form-control" type="text" id="location" name="location" value="{{$current_user->company->location}}">
                                <label for="location">Location</label>
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-material input-group floating">
                                <input class="form-control" type="text" id="website" name="website" value="{{$current_user->company->website}}">
                                <label for="website">Website</label>
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material input-group floating">
                                <textarea class="form-control" id="description" name="description" rows="3">{{$current_user->company->description}}</textarea>
                                <label for="password">Description</label>
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button class="btn btn-sm btn-success" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="tab-pane" id="btabs-alt-static-justified-settings">
            <h4 class="font-w300 push-15">Settings</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="btabs-alt-static-justified-home">
            <h4 class="font-w300 push-15">Home Tab</h4>
            <p>...</p>
        </div>
        <div class="tab-pane" id="btabs-alt-static-justified-profile">
            <h4 class="font-w300 push-15">Profile Tab</h4>
            <p>...</p>
        </div>
    </div>
</div>
@endsection