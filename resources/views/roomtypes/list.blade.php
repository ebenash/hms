@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Room Types
    </h1>
@endsection
@section('content')

<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Room Type <small>List</small></h3>

		<div class="pull-right">
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-roomtype"><i class="fa fa-plus"></i> Add New Room Type</a>
			<a href="{{route('rooms')}}" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Rooms</a>
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Room Type Name</th>
					<th class="hidden-sm">Price From</th>
					<th class="hidden-sm">Max Persons</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_roomtypes as $roomtype)
                    <tr>
                        <td class="text-center">{{$count}}</td>
                        <td class="font-w600"><a href="#" data-toggle="modal" data-target="#modal-view{{$roomtype->id}}" title="View Room Type">{{$roomtype->name}}</a></td>
                        <td class="hidden-sm">{{$roomtype->price_from}}</td>
                        <td class="hidden-sm">{{$roomtype->max_persons}}</td>
                        <td class="text-center">
                            <div class="btn-group">
                                @php
                                    $deleteurl = route('roomtypes-destroy',$roomtype->id);
                                    // $successurl = route('settings-tab','users');
                                @endphp
                                <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modal-view-roomtype{{$roomtype->id}}" title="View Room Type"> <i class="fa fa-eye"> </i></a></div>
                                <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-info"  data-toggle="modal" data-target="#modal-update-roomtype{{$roomtype->id}}" title="Update Room Type"> <i class="fa fa-edit"> </i></a></div>
                                {{-- <div style="display: inline-block;"><a href="/roomtypes/{{$roomtype->id}}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Room Type"> <i class="fa fa-edit"></i> </a></div> --}}
                                <div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Room Type" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-view-roomtype{{$roomtype->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-popout">
                            <div class="modal-content">
                                <div class="block block-themed block-transparent remove-margin-b">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title">Room Type Info</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="si si-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <div>
                                            <div class="form-group">
                                                <div class="">Room Type Name: <b>{{$roomtype->name}}</b></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">Price Starting From: <b>{{$roomtype->price_from}}</b></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">Max Persons: <b>{{$roomtype->max_persons}}</b></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">Bed Type: <b>{{$roomtype->bed_type}}</b></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">Category: <b>{{$roomtype->category}}</b></div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">Description: <b><?=$roomtype->description?></b></div>
                                            </div>


                                            <div class="row items-push js-gallery img-fluid-100">
                                                @if ($roomtype->image_one)
                                                    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
                                                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" onclick="closeModal('#modal-view{{$roomtype->id}}')"  href="{{ asset($roomtype->image_one)}}">
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_one)}}" alt="">
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($roomtype->image_two)
                                                    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
                                                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" onclick="closeModal('#modal-view{{$roomtype->id}}')" href="{{ asset($roomtype->image_two)}}">
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_two)}}" alt="">
                                                        </a>
                                                    </div>
                                                @endif
                                                @if ($roomtype->image_three)
                                                    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
                                                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" onclick="closeModal('#modal-view{{$roomtype->id}}')" href="{{ asset($roomtype->image_three)}}">
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_three)}}" alt="">
                                                        </a>
                                                    </div>
                                                @endif

                                            </div>
                                            <!-- Slider with dots -->
                                            {{-- <div class="block block-rounded">
                                                <div class="block-header">
                                                    <h3 class="block-title">Images</h3>
                                                </div>
                                                <div class="js-slider" data-dots="true">
                                                    @if ($roomtype->image_one)
                                                        <div>
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_one)}}" alt="photo">
                                                        </div>
                                                    @endif
                                                    @if ($roomtype->image_two)
                                                        <div>
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_two)}}" alt="photo">
                                                        </div>
                                                    @endif
                                                    @if ($roomtype->image_three)
                                                        <div>
                                                            <img class="img-fluid" src="{{ asset($roomtype->image_three)}}" alt="photo">
                                                        </div>
                                                    @endif
                                                </div>
                                                <!-- END Slider with dots -->
                                            </div> --}}
                                            <!-- END Dots -->
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                    {{-- <button class="btn btn-lg btn-primary" type="button" data-dismiss="modal"><i class="fa fa-calendar-check-o"></i> Submit</button> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="modal-update-roomtype{{$roomtype->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-popout">
                            <div class="modal-content">
                                <div class="block block-themed block-transparent mb-0">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title">Update Room Type</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="si si-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <form method="post" action="{{route('roomtypes-update',$roomtype->id)}}" class="form-horizontal push-10-t">
                                        {{ csrf_field() }}
                                        <div class="block-content">
                                            <div class="form-group">
                                                <label for="material-text2">Room Type Name: <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{$roomtype->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Price Starting From (GHS): <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="text" name="price_from" class="form-control" value="{{$roomtype->price_from}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Max Persons: <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="number" name="max_persons" class="form-control" min="1" max="10" value="{{$roomtype->max_persons}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Bed Type: eg. "1 King Bed" <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="text" name="bed_type" class="form-control" value="{{$roomtype->bed_type}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Category: <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <select name="category" id="category" class="form-control">
                                                    <option value="room" {{$roomtype->category == "room" ? 'selected' : ''}}>Room</option>
                                                    <option value="suite" {{$roomtype->category == "suite" ? 'selected' : ''}}>Suite</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Image 1 URL: <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="text" name="image_one" class="form-control" value="{{$roomtype->image_one}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Image 2 URL: </label>
                                                <input type="text" name="image_two" class="form-control" value="{{$roomtype->image_two}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Image 3 URL: </label>
                                                <input type="text" name="image_three" class="form-control" value="{{$roomtype->image_three}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="material-text2">Description: </label>
                                                <textarea name="description" id="description" class="form-control" cols="30" rows="10"> {{$roomtype->description}}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                                <button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-calendar-check-o"></i> Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $count++;
                    @endphp
				@endforeach
			</tbody>
		</table>

    </div>

    <div class="modal fade" id="modal-view-add-roomtype" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add Room Type</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <form method="post" action="{{route('roomtypes-store')}}" class="form-horizontal push-10-t">
                        {{ csrf_field() }}
                        <div class="block-content">
                            <div class="form-group">
                                <label for="material-text2">Room Type Name: <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Price Starting From (GHS): <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="price_from" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Max Persons: <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="number" name="max_persons" class="form-control" min="1" max="10">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Bed Type: eg. "1 King Bed" <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="bed_type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Category: <span class="text-danger" style="display: inline-block;">*</span></label>
                                <select name="category" id="category" class="form-control">
                                    <option value="room">Room</option>
                                    <option value="suite">Suite</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Image 1 URL: <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="image_one" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Image 2 URL: </label>
                                <input type="text" name="image_two" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Image 3 URL: </label>
                                <input type="text" name="image_three" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="material-text2">Description: </label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                <button class="btn btn-lg btn-primary" type="submit"><i class="fa fa-calendar-check-o"></i> Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
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
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.js') }}"></script>

    <!-- Page JS Helpers (Slick Slider Plugin) -->
    <script>jQuery(function(){One.helpers('magnific-popup');});</script>
    <script>
        function closeModal(modal){
            $(modal).modal('toggle');
        }
    </script>
@endsection


