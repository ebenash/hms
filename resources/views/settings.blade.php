@extends('layouts.app')

@section('page-header')
<h1 class="flex-sm-fill h3 my-2">
    App Settings <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
</h1>
@endsection

@section('content')

<div class="block block-rounded overflow-hidden">
    <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{isset($tab) ? ($tab == 'company' ? 'active' : '') : 'active'}}" href="#settings-company">
                <i class="fa fa-fw fa-cog mr-1"></i>
                Company Information
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($tab) ? ($tab == 'users' ? 'active' : '') : ''}}" href="#settings-users">
                <i class="fa fa-fw fa-users mr-1"></i>
                Users
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{isset($tab) ? ($tab == 'theme' ? 'active' : '') : ''}}" href="#settings-theme">
                <i class="fa fa-fw fa-paint-roller mr-1"></i>
                Theme
            </a>
        </li>
    </ul>
    <div class="block-content tab-content overflow-hidden">
        <!-- Company Information -->
        <div class="tab-pane fade fade-up {{isset($tab) ? ($tab == 'company' ? 'show active' : '') : 'show active'}}" id="settings-company" role="tabpanel">
            <form class="form-horizontal push-10-t push-10" action="{{route('update-settings',auth()->user()->company->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="update_type" value="company">
                <div class="form-group row">
                    <div class="col-lg-12">
                        <label for="company_name">Company Name</label>
                        <input class="form-control" type="text" id="company_name" name="company_name" value="{{$current_user->company->name}}">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-lg-6">
                        <label for="email">Email</label>
                        <input class="form-control" type="email" id="email" name="email" value="{{$current_user->company->email}}">
                    </div>
                    <div class="col-lg-6">
                        <label for="phone">Phone</label>
                        <input class="form-control" type="tel" id="phone" name="phone" value="{{$current_user->company->phone}}">
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
                        <label for="website">Website</label>
                        <input class="form-control" type="text" id="website" name="website" value="{{$current_user->company->website}}">
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

        <!-- Users -->
        <div class="tab-pane fade fade-up {{isset($tab) ? ($tab == 'users' ? 'show active' : '') : ''}}" id="settings-users" role="tabpanel">
            <div class="block-content block-content-full">
                <div class="pull-right mb-3">
                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-user"><i class="fa fa-plus"></i> Add New User</a>
                </div>
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
                        <?php $count=1; ?>
                        @foreach($all_users as $user)
                        <tr>
                            <td class="text-center">{{$count++}}</td>
                            <td class="font-w600">{{$user->name}}</td>
                            <td class="hidden-xs">{{$user->title}}</td>
                            <td class="hidden-xs">{{$user->phone}}</td>
                            <td class="hidden-xs">{{$user->email}}</td>
                            <td class="hidden-xs">{{$user->role->role_name}}</td>
                            <td class="text-center">
                                @php
                                    $deleteurl = route('users-destroy',$user->id);
                                    $successurl = route('settings-tab','users');
                                @endphp
                                <div class="btn-group">
                                    {{-- <div style="display: inline-block;"><a href="/users/{{$user->id}}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="View User"> <i class="fa fa-eye"> </i></a></div> --}}
                                    <div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove User" onclick="confimdelete('{{$deleteurl}}','{{$successurl}}')"><i class="fa fa-times"> </i></button></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Users -->

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

