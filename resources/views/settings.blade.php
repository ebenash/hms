@extends('layouts.app')

@section('page-header')
<h1 class="flex-sm-fill h3 my-2">
    App Settings <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
</h1>
@endsection

@section('content')

<div class="block block-rounded overflow-hidden">
    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
        @can('edit company')
            <li class="nav-item">
                <a class="nav-link {{isset($tab) ? ($tab == 'company' ? 'active' : '') : 'active'}}" href="#settings-company">
                    <i class="fa fa-fw fa-cog mr-1"></i>
                    Company Information
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{isset($tab) ? ($tab == 'phones' ? 'active' : '') : 'active'}}" href="#settings-phones">
                    <i class="fa fa-fw fa-mobile mr-1"></i>
                    SMS Notification Phones
                </a>
            </li>
        @endcan
        @can('view users')
            <li class="nav-item">
                <a class="nav-link {{isset($tab) ? ($tab == 'users' ? 'active' : '') : ''}}" href="#settings-users">
                    <i class="fa fa-fw fa-users mr-1"></i>
                    Users
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link {{isset($tab) ? ($tab == 'theme' ? 'active' : '') : ''}}" href="#settings-theme">
                <i class="fa fa-fw fa-paint-roller mr-1"></i>
                Theme
            </a>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        @can('edit company')
            <!-- Company Information -->
            <div class="tab-pane fade fade-up {{isset($tab) ? ($tab == 'company' ? 'show active' : '') : 'show active'}}" id="settings-company" role="tabpanel">
                <form class="form-horizontal push-10-t push-10" action="{{route('update-settings',auth()->user()->company->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="update_type" value="company">
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="company_name">Company Name</label>
                            <input class="form-control" type="text" id="company_name" name="company_name" value="{{$current_user->company->name}}">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Phone</label>
                            <input class="form-control" type="tel" id="phone" name="phone" value="{{$current_user->company->phone}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="email">Email</label>
                            <input class="form-control" type="email" id="email" name="email" value="{{$current_user->company->email}}">
                        </div>
                        <div class="col-lg-6">
                            <label for="website">Website</label>
                            <input class="form-control" type="text" id="website" name="website" value="{{$current_user->company->website}}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="phone">Company Logo</label><br>
                            <input type="file" name="logo" class="">
                        </div>
                        <div class="col-lg-6">
                            <label for="phone">Current Logo</label>
                            <div class="form-material input-group floating">
                                <div class="thumbnail" style="width: 200px; height: 70px;"><img src="{{route('hms-uploads-file',($current_user->company->logo ?? 'mist_logo.jpeg'))}}" height="70px"/></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-6">
                            <label for="location">Location</label>
                            <input class="form-control" type="text" id="location" name="location" value="{{$current_user->company->location}}">
                        </div>
                        <div class="col-lg-6">
                            <label for="currency">Currency</label>
                            <select class="form-control" id="currency" name="currency">
                                <option value="GHS" {{$current_user->company->currency == 'GHS' ? 'selected' : ''}}>GHS</option>
                                <option value="USD" {{$current_user->company->currency == 'USD' ? 'selected' : ''}}>USD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label for="password">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3">{{$current_user->company->description}}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button class="btn btn-sm btn-primary" type="submit">Update</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- END Company Information -->
            <!-- Phones -->
            <div class="tab-pane {{isset($tab) ? ($tab == 'phones' ? 'show active' : '') : ''}}" id="settings-phones" role="tabpanel">
                <div class="block-header">
                    <h3 class="block-title">SMS Notification <small>Phones</small></h3>

                    <div class="pull-right mb-3">
                        <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-phone"><i class="fa fa-plus"></i> Add New Phone</a>
                    </div>

                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="hidden-xs">#</th>
                                <th>Phone Name</th>
                                <th class="hidden-xs">Phone Number</th>
                                <th class="hidden-xs">Status</th>
                                <th class="hidden-xs">Date Added</th>
                                <th class="text-center" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count=1; @endphp
                            @foreach($all_phones as $phone)
                            <tr>
                                <td class="text-center">{{$count++}}</td>
                                <td class="font-w600">{{$phone->phone_name}}</td>
                                <td class="hidden-xs">{{$phone->phone_number}}</td>
                                <td class="hidden-xs">@if($phone->status == 1) <span class="badge badge-success">Active</span>  @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                <td class="hidden-xs">{{date_format(new DateTime($phone->created_at), 'l jS F, Y')}}</td>
                                <td class="text-center">
                                    @php
                                        $deleteurl = route('phone-destroy',$phone->id);
                                        $successurl = route('settings-tab','phones');
                                    @endphp
                                    <div class="btn-group">
                                        <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modal-edit{{$phone->id}}" title="Edit Phone"> <i class="fa fa-edit"></i> </a></div>
                                        <div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Phone" onclick="confimdelete('{{$deleteurl}}','{{$successurl}}')"><i class="fa fa-times"> </i></button></div>
                                    </div>
                                </td>
                                <div class="modal fade" id="modal-edit{{$phone->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog  modal-dialog-popout">
                                        <div class="modal-content">
                                            <div class="block block-themed block-transparent remove-margin-b">
                                                <div class="block-header bg-primary-dark">
                                                    <h3 class="block-title">Update Phone</h3>
                                                    <div class="block-options">
                                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                            <i class="si si-close"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="block-content">
                                                    <form method="post" action="{{route('phone-update',$phone->id)}}" class="form-horizontal push-10-t">
                                                        {{ csrf_field() }}
                                                        <div class="form-group">
                                                            <label for="material-text2">Phone Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                                            <input type="text" name="phone_name" class="form-control" value="{{$phone->phone_name}}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="material-text2">Phone Number <span class="text-danger" style="display: inline-block;">*</span></label>
                                                            <input type="text" name="phone_number" class="form-control" value="{{$phone->phone_number}}">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="material-text2">Phone Status <span class="text-danger" style="display: inline-block;">*</span></label>
                                                            <select name="status" class="form-control">
                                                                <option value="1" {{$phone->status == 1 ? 'selected' : ''}}>Available</option>
                                                                <option value="0" {{$phone->status == 0 ? 'selected' : ''}}>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                                            <button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-calendar-check-o"></i> Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Phones -->
        @endcan
        @can('view users')
            <!-- Users -->
            <div class="tab-pane {{isset($tab) ? ($tab == 'users' ? 'show active' : '') : ''}}" id="settings-users" role="tabpanel">
                <div class="block-header">
                    <h3 class="block-title">Users <small></small></h3>
                    @can('add users')
                        <div class="pull-right mb-3">
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-user"><i class="fa fa-plus"></i> Add New User</a>
                        </div>
                    @endcan

                </div>
                <div class="block-content block-content-full">
                    <!-- DataTables init on table by adding .js-dataTable-full-pagination class, functionality initialized in js/pages/base_tables_datatables.js -->
                    <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                        <thead>
                            <tr>
                                <th class="hidden-xs">#</th>
                                <th>User Name</th>
                                <th class="hidden-xs">Job Title</th>
                                <th class="hidden-xs">Phone Number</th>
                                <th class="hidden-xs">Email</th>
                                <th class="hidden-xs">User Role</th>
                                <th class="text-center" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $count=1; @endphp
                            @foreach($all_users as $user)
                            <tr>
                                <td class="text-center">{{$count++}}</td>
                                <td class="font-w600">{{$user->name}}</td>
                                <td class="hidden-xs">{{$user->title}}</td>
                                <td class="hidden-xs">{{$user->phone}}</td>
                                <td class="hidden-xs">{{$user->email}}</td>
                                <td class="hidden-xs">{{ucfirst(implode(", ",json_decode($user->getRoleNames())))}}</td>
                                <td class="text-center">
                                    @php
                                        $deleteurl = route('users-destroy',$user->id);
                                        $successurl = route('settings-tab','users');
                                    @endphp
                                    <div class="btn-group">
                                        @can('edit users')
                                            @if($user->hasRole('administrator') && auth()->user()->hasRole('administrator'))
                                                <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-update-user{{$user->id}}" title="Update User"> <i class="fa fa-edit"> </i></a></div>
                                            @elseif(!$user->hasRole('administrator'))
                                                <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-update-user{{$user->id}}" title="Update User"> <i class="fa fa-edit"> </i></a></div>
                                            @endif
                                        @endcan
                                        @can('remove users')<div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove User" onclick="confimdelete('{{$deleteurl}}','{{$successurl}}')"><i class="fa fa-times"> </i></button></div>@endcan
                                    </div>
                                </td>
                                @can('edit users')
                                    <div class="modal fade" id="modal-update-user{{$user->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-popout">
                                            <div class="modal-content">
                                                <div class="block block-themed block-transparent mb-0">
                                                    <div class="block-header bg-primary-dark">
                                                        <h3 class="block-title">Update User</h3>
                                                        <div class="block-options">
                                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                                <i class="si si-close"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="block-content block-content-narrow">


                                                    <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ route('user-update',$user->id) }}" method="post">
                                                        @csrf
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <div class="form-material form-material-success">
                                                                    <label for="register-username">{{ __('Name') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="Please enter a Name">
                                                                    @error('name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <div class="form-material form-material-success">
                                                                    <label for="register-title">{{ __('Job Title') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $user->title }}" required autocomplete="title" autofocus placeholder="Please enter a Title">
                                                                    @error('title')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <div class="form-material form-material-success">
                                                                    <label for="register-phone">{{ __('Phone Number') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ $user->phone }}" required autocomplete="phone" placeholder="Please provide your phone number">
                                                                    @error('phone')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <div class="form-material form-material-success">
                                                                    <label for="register-email">{{ __('E-Mail Address') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" placeholder="Please provide your email">
                                                                    @error('email')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-xs-12">
                                                                <div class="form-material form-material-success">
                                                                    <label for="register-role_id">{{ __('User Role') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                                                    <select id="role_id" type="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id" required >
                                                                        <option value="">Select Role</option>

                                                                        @foreach($roles as $role)
                                                                            @if ($role->name == 'administrator')
                                                                                @if (auth()->user()->hasRole('administrator'))
                                                                                    <option value="{{$role->name}}" {{$user->hasRole($role->name) ? 'selected' : ''}}>{{ucfirst($role->name)}}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="{{$role->name}}" {{$user->hasRole($role->name) ? 'selected' : ''}}>{{ucfirst($role->name)}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    @error('role_id')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                                            <button class="btn btn-lg btn-primary" type="submit">Update User</button>
                                                        </div>
                                                    </form>
                                                    <!-- END Register Form -->
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                @endcan
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END Users -->
        @endcan
        <!-- Theme -->
        <div class="tab-pane fade fade-up {{isset($tab) ? ($tab == 'theme' ? 'show active' : '') : ''}}" id="settings-theme" role="tabpanel">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <!-- Toggle Themes functionality initialized in Template._uiHandleTheme() -->
                    <div class="row text-center">
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-default text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme',null)" data-theme="default" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Default</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-amethyst text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme','amethyst')" data-theme="{{ mix('css/themes/amethyst.css')}}" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Amethyst</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-city text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme','city')" data-theme="{{ mix('css/themes/city.css')}}" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">City</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-flat text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme','flat')" data-theme="{{ mix('css/themes/flat.css')}}" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Flat</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-modern text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme','modern')" data-theme="{{ mix('css/themes/modern.css')}}" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Modern</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-smooth text-white-75 mx-auto mb-3" data-toggle="theme" onclick="changeTheme('theme','smooth')" data-theme="{{ mix('css/themes/smooth.css')}}" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Smooth</div>
                        </div>
                    </div>
                    <hr>
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <div class="row text-center">
                        <div class="col-6 col-xl-2 offset-xl-1 py-4">
                            <a class="item item-link-pop item-circle bg-sidebar-light text-muted mx-auto mb-3" data-toggle="layout"  onclick="changeTheme('sidebar','sidebar-light')" data-action="sidebar_style_light" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Light Sidebar</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-sidebar-dark text-white-75 mx-auto mb-3" data-toggle="layout"  onclick="changeTheme('sidebar','sidebar-dark')" data-action="sidebar_style_dark" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Dark Sidebar</div>
                        </div>
                        <div class="col-6 col-xl-2 offset-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-header-light text-muted mx-auto mb-3" data-toggle="layout"  onclick="changeTheme('header','page-header-light')" data-action="header_style_light" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Light Header</div>
                        </div>
                        <div class="col-6 col-xl-2 py-4">
                            <a class="item item-link-pop item-circle bg-header-dark text-white-75 mx-auto mb-3" data-toggle="layout"  onclick="changeTheme('header','page-header-dark')" data-action="header_style_dark" href="javascript:void(0)">
                                <i class="fa fa-paint-roller"></i>
                            </a>
                            <div class="font-w600">Dark Header</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Theme -->

    </div>
</div>

@can('edit company')
    <div class="modal fade" id="modal-view-add-phone" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add Phone Info</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-narrow">
                        <form method="post" action="{{route('phone-store')}}" class="form-horizontal push-10-t">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="material-text2">Phone Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="phone_name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="material-text2">Phone Number <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="phone_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="material-text2">Phone Status <span class="text-danger" style="display: inline-block;">*</span></label>
                                <select name="status" class="form-control">
                                    <option value="1">Available</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-calendar-check-o"></i> Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan

@can('add users')
    <div class="modal fade" id="modal-view-add-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add New User</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-narrow">


                    <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ route('user-store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <label for="register-username">{{ __('Name') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Please enter a Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <label for="register-title">{{ __('Job Title') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Please enter a Title">
                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <label for="register-phone">{{ __('Phone Number') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                    <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Please provide your phone number">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <label for="register-email">{{ __('E-Mail Address') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Please provide your email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material form-material-success">
                                    <label for="register-role_id">{{ __('User Role') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                    <select id="role_id" type="role_id" class="form-control @error('role_id') is-invalid @enderror" name="role_id" required >
                                        <option value="">Select Role</option>
                                        @foreach($roles as $role)
                                            @if ($role->name == 'administrator')
                                                @if (auth()->user()->hasRole('administrator'))
                                                    <option value="{{$role->name}}">{{ucfirst($role->name)}}</option>
                                                @endif
                                            @else
                                                <option value="{{$role->name}}">{{ucfirst($role->name)}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                            <button class="btn btn-lg btn-primary" type="submit">Create User</button>
                        </div>
                    </form>
                    <!-- END Register Form -->
                </div>
            </div>
            </div>
        </div>
    </div>
@endcan

@endsection

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('js/pages/tables_datatables.js') }}"></script>
    <script>
        // alert(session.get("tab"));
    </script>
@endsection

