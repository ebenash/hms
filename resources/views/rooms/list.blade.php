@extends('layouts.app')
@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Rooms
    </h1>
@endsection
@section('content')

<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Room <small>List</small></h3>

		<div class="pull-right">
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-room"><i class="fa fa-plus"></i> Add New Room</a>
			<a href="{{route('roomtypes')}}" class="btn btn-sm btn-primary"><i class="fa fa-list"></i> Room Types</a>
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th>Room Name</th>
					<th class="hidden-sm">Room Type</th>
					<th class="hidden-sm">Room Status</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_rooms as $room)
                    <tr>
                        <td class="text-center">{{$count}}</td>
                        <td class="font-w600">{{$room->name}}</td>
                        <td class="hidden-sm">{{$room->roomtype->name}}</td>
                        <td class="hidden-sm">@if($room->status == 1) <span class="badge badge-success">Available</span>  @else <span class="badge badge-danger">Inactive</span> @endif</td>
                        <td class="text-center">
                            @php
                                $deleteurl = route('rooms-destroy',$room->id);
                                // $successurl = route('settings-tab','users');
                            @endphp
                            <div class="btn-group">
                                <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modal-edit{{$room->id}}" title="Edit Room"> <i class="fa fa-edit"></i> </a></div>
                                <div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Room" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div>
                                {{-- <div style="display: inline-block;"><form method="post" action="/rooms/{{$room->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"> </i></button></form></div> --}}
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="modal-edit{{$room->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog  modal-dialog-popout">
                            <div class="modal-content">
                                <div class="block block-themed block-transparent remove-margin-b">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title">Update Room</h3>
                                        <div class="block-options">
                                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                <i class="si si-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <form method="post" action="{{route('rooms-update',$room->id)}}" class="form-horizontal push-10-t">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="material-text2">Room Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <input type="text" name="name" class="form-control" value="{{$room->name}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="type">Room Type<span class="text-danger" style="display: inline-block;">*</span></label>
                                                <select name="type" class="form-control">
                                                    <option value="">Select Room Type</option>
                                                    @foreach($all_roomtypes as $roomtype)
                                                        <option value="{{$roomtype->id}}" {{$room->room_type_id == $roomtype->id ? 'selected' : ''}}>{{$roomtype->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="material-text2">Room Status <span class="text-danger" style="display: inline-block;">*</span></label>
                                                <select name="status" class="form-control">
                                                    <option value="1" {{$room->status == 1 ? 'selected' : ''}}>Available</option>
                                                    <option value="0" {{$room->status == 0 ? 'selected' : ''}}>Inactive</option>
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
                    @php
                        $count++;
                    @endphp
				@endforeach
			</tbody>
		</table>
    </div>
    <div class="modal fade" id="modal-view-add-room" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-dialog-popout">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add Room Info</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content block-content-narrow">
                        <form method="post" action="{{route('rooms-store')}}" class="form-horizontal push-10-t">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="material-text2">Room Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="type">Room Type<span class="text-danger" style="display: inline-block;">*</span></label>
                                <select name="type" class="form-control">
                                    <option value="">Select Room Type</option>
                                    @foreach($all_roomtypes as $roomtype)
                                        <option value="{{$roomtype->id}}">{{$roomtype->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="material-text2">Room Status <span class="text-danger" style="display: inline-block;">*</span></label>
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
@endsection

