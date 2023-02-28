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
                        @can('add guests')
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
                        @endcan
                        @can('add reservations')
                            <div class="col-6">
                                <!-- Reservation -->
                                {{-- <a class="block block-rounded block-link-shadow bg-body" href="{{route('reservations-create')}}"> --}}
                                <a class="block block-rounded block-link-shadow bg-body" href="javascript:void(0)" data-toggle="modal" data-target="#modal-view-add-reservation">
                                    <div class="block-content text-center">
                                        <i class="si si-calendar fa-2x text-primary"></i>
                                        <p class="font-w600 font-size-sm mt-2 mb-3">
                                            Add Reservation
                                        </p>
                                    </div>
                                </a>
                                <!-- END Reservation -->
                            </div>
                        @endcan
                        @can('view rooms')
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
                        @endcan
                        @can('view roomtypes')
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
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Apps Modal -->
@can('add guests')
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
@endcan
@can('add reservations')
    <div class="modal fade" id="modal-view-add-reservation" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl  modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add New Reservation</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-narrow">

                        <div class="form-row col-lg-12 mb-3">


                            <label for="roomtype">Search For Guest Below:</label>
                            <div class="input-group col-lg-12 mb-3">
                                <input type="text" class="form-control" id="search_guest" placeholder="Guest Search..">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-fw fa-search"></i>
                                    </span>
                                    @can('add guests')
                                        <div class="pull-right">
                                            <a href="#" class="btn btn-primary" onclick="closeOneOpenAnotherModal('#modal-view-add-reservation','#modal-view-add-guest')"><i class="fa fa-plus"></i> Add New Guest</a>
                                        </div>
                                    @endcan
                                </div>
                            </div>

                            <div class="tab-pane fade fade-up active show col-lg-12" role="tabpanel" id="table-div" style="display: block;">
                                <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light" id="summary-div">
                                    <span class="text-primary font-w700" >0</span> results found for <mark class="text-danger" id="guest_input">guest</mark>
                                </div>

                                <table class="table table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="d-none d-sm-table-cell text-center" style="width: 40px;">#</th>
                                            <th>Name</th>
                                            <th class="d-none d-sm-table-cell">Email</th>
                                            <th class="d-none d-lg-table-cell" style="width: 15%;">Phone</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="search-div">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light">
                            <span class="text-primary font-w700">{{count($search_guests)}}</span> guests found for <mark class="text-danger">{{$keyword}}</mark>
                        </div>
                        <table class="table table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th class="d-none d-sm-table-cell text-center" style="width: 40px;">#</th>
                                    <th>Name</th>
                                    <th class="d-none d-sm-table-cell">Email</th>
                                    <th class="d-none d-lg-table-cell" style="width: 15%;">Phone</th>
                                    <th class="text-center" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $count=1; @endphp
                                @foreach($search_guests as $guest)
                                    <tr>
                                        <td class="d-none d-sm-table-cell text-center">
                                            <span class="badge badge-pill badge-primary">{{$count++}}</span>
                                        </td>
                                        <td class="font-w600"><a href="#" data-toggle="modal" data-target="#modal-view{{$guest->id}}" title="View Guest">{{$guest->full_name}}</a></td>
                                        <td class="d-none d-sm-table-cell">{{$guest->email}}</td>
                                        <td class="d-none d-sm-table-cell">{{$guest->phone}}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{route('reservations-create-guest',$guest->id)}}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Make Reservation">
                                                    <i class="fa fa-address-book"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcan
