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
