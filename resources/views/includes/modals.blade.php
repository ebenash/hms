<!-- Apps Modal -->
<!-- Opens from the modal toggle button in the header -->
<div class="modal fade" id="one-modal-apps" tabindex="-1" role="dialog" aria-labelledby="one-modal-apps" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="block block-rounded block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Apps</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-full">
                    <div class="row gutters-tiny">
                        <div class="col-6">
                            <!-- Guest -->
                            <a class="block block-rounded block-link-shadow bg-body" href="javascript:void(0)" data-toggle="modal" data-target="#modal-view-add-guest">
                                <div class="block-content text-center">
                                    <i class="si si-user fa-2x text-primary"></i>
                                    <p class="font-w600 font-size-sm mt-2 mb-3">
                                        Add New Guest
                                    </p>
                                </div>
                            </a>
                            <!-- END Guest -->
                        </div>
                        <div class="col-6">
                            <!-- Reservation -->
                            <a class="block block-rounded block-link-shadow bg-body" href="{{route('reservations-create')}}">
                                <div class="block-content text-center">
                                    <i class="si si-calendar fa-2x text-primary"></i>
                                    <p class="font-w600 font-size-sm mt-2 mb-3">
                                        Add Reservation
                                    </p>
                                </div>
                            </a>
                            <!-- END Reservation -->
                        </div>
                        <div class="col-6">
                            <!-- Rooms -->
                            <a class="block block-rounded block-link-shadow bg-body mb-0" href="{{route('rooms')}}">
                                <div class="block-content text-center">
                                    <i class="si si-key fa-2x text-primary"></i>
                                    <p class="font-w600 font-size-sm mt-2 mb-3">
                                        Rooms
                                    </p>
                                </div>
                            </a>
                            <!-- END Rooms -->
                        </div>
                        <div class="col-6">
                            <!-- Room Type -->
                            <a class="block block-rounded block-link-shadow bg-body mb-0" href="{{route('roomtypes')}}">
                                <div class="block-content text-center">
                                    <i class="si si-home fa-2x text-primary"></i>
                                    <p class="font-w600 font-size-sm mt-2 mb-3">
                                        Room Types
                                    </p>
                                </div>
                            </a>
                            <!-- END Room Type -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Apps Modal -->
<div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-dialog-top">
        <div class="modal-content">
            <!-- Apps Block -->
            <div class="block block-themed block-transparent">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Quick Links</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row text-center">
                        <div class="col-xs-6">
                            <a class="block block-rounded" href="base_pages_dashboard.html">
                                <div class="block-content text-white bg-default">
                                    <i class="si si-calendar fa-2x"></i>
                                    <div class="font-w600 push-15-t push-15">Add New Reservation</div>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <a class="block block-rounded" href="frontend_home.html">
                                <div class="block-content text-white bg-modern">
                                    <i class="si si-user fa-2x"></i>
                                    <div class="font-w600 push-15-t push-15">Add New Guest</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Apps Block -->
        </div>
    </div>
</div>
<!-- END Apps Modal -->

<div class="modal fade" id="modal-view-add-guest" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Add Guest Info</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-narrow">

                    <form method="post" action="{{route('guests-store')}}" class="form-horizontal push-10-t">
                        @csrf
                        <div class="form-group">
                            <label for="material-text2">Full Name <span class="text-danger" style="display: inline-block;">*</span></label>
                            <input type="text" name="full_name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="material-text2">Email <span class="text-danger" style="display: inline-block;">*</span></label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="material-text2">Phone <span class="text-danger" style="display: inline-block;">*</span></label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="material-text2">City</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                        {{-- <div class="form-group">
                            <label for="example2-select2">Country</label>
                            @include('includes.countries')
                        </div> --}}
                        <div class="form-group">
                            <label for="example-autocomplete2">Country</label>
                            <input class="js-autocomplete form-control" type="text" id="example-autocomplete2" name="country">
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-lg btn-alt-primary" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
<div class="modal fade" id="modal-view-roomtypes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Room Types List</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content block-content-narrow">
                    <div class="pull-right">
                        <a href="#" class="btn btn-sm btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#modal-view-add-roomtype"><i class="fa fa-plus"></i> Add New Room Type</a>
                    </div>
                    <br/><br/>
                    <table class="table table-striped table-borderless">
                        <thead>
                            <tr>
                                <th class="hidden-xs">Room Type</th>
                                <th class="text-center" style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count=1; ?>
                            @foreach($all_roomtypes as $roomtype)
                            <tr>
                                <td class="font-w600">{{$roomtype->name}}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-view-edit{{$roomtype->id}}" title="Edit Room Type"> <i class="fa fa-edit"></i></a></div>
                                        <div style="display: inline-block;"><form method="post" action="/roomtypes/{{$roomtype->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"></i></button></form></div>
                                    </div>
                                </td>
                            </tr>
                        <div class="modal fade" id="modal-view-edit{{$roomtype->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-popout">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <ul class="block-options">
                                                    <li>
                                                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                                                    </li>
                                                </ul>
                                                <h3 class="block-title">Room Type Edit</h3>
                                            </div>
                                            <form method="post" action="/roomtypes/{{$roomtype->id}}" class="form-horizontal push-10-t">
                                                {{ csrf_field() }}
                                                {{ method_field('PUT')}}
                                                <div class="block-content">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <div class="form-material floating">
                                                                <input type="text" class="form-control" value="{{$roomtype->name}}" name="name">
                                                                <label for="material-text2">Room Type Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-12 pull-right">
                                                            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <br/><br/><br/><br/>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}


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


                <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ route('users-store') }}" method="post">
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
                                    @foreach($all_roles as $role)
                                        <option value="{{$role->id}}">{{$role->role_name}}</option>
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
                    {{-- <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <label for="register-password">{{ __('Password') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Choose a strong password..">
                                @error('password')
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
                                <label for="register-password2">{{ __('Confirm Password') }} <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="..and confirm it">
                            </div>
                        </div>
                    </div> --}}

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
