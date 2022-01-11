 <!-- Opens from the button in the header -->
<div class="modal fade" id="apps-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-sm modal-dialog modal-dialog-top">
        <div class="modal-content">
            <!-- Apps Block -->
            <div class="block block-themed block-transparent">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Quick Links</h3>
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
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Guest Info</h3>
                </div> 
                <div class="block-content block-content-narrow">
                    <h2>Add New Guest</h2>

                
                    <form method="post" action="/guests/store" class="form-horizontal push-10-t">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="text" name="first_name" class="form-control">
                                <label for="material-text2">First Name <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="text" name="last_name" class="form-control">
                                <label for="material-text2">Last Name <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="email" name="email" class="form-control">
                                <label for="material-text2">Email <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-12">
                        <div class="form-material floating">
                                <input type="text" name="phone" class="form-control">
                                <label for="material-text2">Phone <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="text" name="city" class="form-control">
                                <label for="material-text2">City</label>
                            </div>
                        </div>
                    </div>
                    
                    <!--<div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                               @include('includes.countries')
                                <label for="example2-select2">Country</label>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="form-material">
                                <input class="js-autocomplete form-control" type="text" id="example-autocomplete2" name="country" placeholder="Countries..">
                                <label for="example-autocomplete2">Country</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-add-room" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Room Info</h3>
                </div> 
                <div class="block-content block-content-narrow">
                    <h2>Add New Room</h2>

                
                    <form method="post" action="/rooms/store" class="form-horizontal push-10-t">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="text" name="name" class="form-control">
                                <label for="material-text2">Room Name <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <input type="text" name="price" class="form-control">
                                <label for="material-text2">Price <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material">
                                <select name="type" class="form-control">
                                    <option value="">Select Room Type</option>
                                    @foreach($all_roomtypes as $roomtype)
                                    <option value="{{$roomtype->id}}">{{$roomtype->name}}</option>
                                    @endforeach
                                </select>
                                <label for="type">Room Type<p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                    <div class="col-sm-12">
                        <div class="form-material floating">
                                <input type="number" name="max_persons" class="form-control">
                                <label for="material-text2">Max Persons <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-9">
                            <div class="form-material floating">
                                <select name="status" class="form-control">
                                    <option value="0">Available</option>
                                    <option value="1">Inactive</option>
                                </select>
                                <label for="material-text2">Room Status <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-roomtypes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Room Types List</h3>
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
                                        <div style="display: inline-block;"><a href="#" class="btn btn-xs btn-primary" data-toggle="modal" data-target="#modal-view-edit{{$roomtype->id}}" title="Edit Room Type"> <i class="fa fa-pencil"></i></a></div>
                                        <div style="display: inline-block;"><form method="post" action="/roomtypes/{{$roomtype->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-xs btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"></i></button></form></div>
                                    </div>
                                </td>
                            </tr>
                        <div class="modal fade" id="modal-view-edit{{$roomtype->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog  modal-dialog-popout">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent remove-margin-b">
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
                                                                <label for="material-text2">Room Type Name <p class="text-danger" style="display: inline-block;">*</p></label>
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
</div>

<div class="modal fade" id="modal-view-add-roomtype" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Add Room Type</h3>
                </div>
                <form method="post" action="/roomtypes/store" class="form-horizontal push-10-t">
                    {{ csrf_field() }}
                    <div class="block-content">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="form-material floating">
                                    <input type="text" class="form-control" name="name">
                                    <label for="material-text2">Room Type Name <p class="text-danger" style="display: inline-block;">*</p></label>
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
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-add-reservation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Reservation Info</h3>
                </div> 
                <div class="block-content block-content-narrow">
                    <h2>Add New Reservation</h2>

                
                    <form method="post" action="/reservations/store" class="form-horizontal push-10-t">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material">
                                 <select class="js-select2 form-control" id="guest" style="width: 100%;" data-placeholder="Choose Guest.." name="guest">
                                    <option></option>
                                    @foreach($all_guests as $guest)
                                    <option value="{{$guest->id}}">{{$guest->first_name.' '.$guest->last_name}}</option>
                                    @endforeach
                                </select>
                                <label for="material-text2">Guest <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material">
                                <select class="js-select2 form-control" id="room" style="width: 100%;" data-placeholder="Choose Room To Be Reserved.." name="room">
                                    <option value="">Select Room To Be Reserved</option>
                                    @foreach($all_rooms->where('status',0) as $room)
                                    <option value="{{$room->id}}">{{$room->name}} - GH₵ {{$room->price}}</option>
                                    @endforeach
                                </select>
                                <label for="material-text2">Room <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
                                <input class="js-datepicker form-control" type="text" id="check_in" name="check_in" placeholder="Choose check-in date..">
                                <label for="material-text2">Check In Date <p class="text-danger" style="display: inline-block;">*</p></label>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="js-datepicker form-material input-group date" data-show-today-button="true" data-show-clear="true" data-show-close="true" data-side-by-side="false">
                                <input class="js-datepicker form-control" type="text" id="check_out" name="check_out" placeholder="Choose check-out date..">
                                <label for="material-text2">Check Out Date <p class="text-danger" style="display: inline-block;">*</p></label>
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <select class="form-control" id="adults" style="width: 100%;" name="adults">
                                    <option>Select Number of Adults</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>                                    
                                </select>
                                <label for="material-text2">Adults <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <select class="form-control" id="children" style="width: 100%;" name="children">
                                    <option>Select Number of Children</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>                                    
                                </select>
                                <label for="material-text2">Children <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating">
                                <select name="status" class="form-control">
                                    <option value="0">Pending</option>
                                    <option value="1">Confirmed</option>
                                    <option value="2">Cancelled</option>
                                </select>
                                <label for="material-text2">Reservation Status <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="form-material floating input-group">
                                <input type="number" name="discount" class="form-control" value="0.0">
                                <label for="material-text2">Discount %</label>
                                <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-view-add-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-popout">
        <div class="modal-content">
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-primary-dark">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">User Info</h3>
                </div> 
                <div class="block-content block-content-narrow">
                    <h2>Add New User</h2>

                
                <form class="js-validation-register form-horizontal push-50-t push-50" action="{{ url('/user/store') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Please enter a Name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="register-username">{{ __('Name') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus placeholder="Please enter a Title">

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="register-title">{{ __('Job Title') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone" placeholder="Please provide your phone number">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="register-phone">{{ __('Phone Number') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Please provide your email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="register-email">{{ __('E-Mail Address') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
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
                                <label for="register-role_id">{{ __('User Role') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Choose a strong password..">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <label for="register-password">{{ __('Password') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="..and confirm it">
                                <label for="register-password2">{{ __('Confirm Password') }} <p class="text-danger" style="display: inline-block;">*</p></label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                            <button class="btn btn-sm btn-block btn-success" type="submit">Create User</button>
                        </div>
                    </div>
                </form>
                <!-- END Register Form -->
            </div>
        </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-default" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>