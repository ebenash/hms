@extends('layouts.app')

@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Guests
    </h1>
@endsection

@section('content')

<!-- Dynamic Table Full -->
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Guest <small>List</small></h3>

		<div class="pull-right">
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-guest"><i class="fa fa-plus"></i> Add New Guest</a>
		</div>
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
			<thead>
				<tr>
					<th class="text-center"></th>
					<th>Name</th>
					<th class="hidden-xs">Email</th>
					<th class="hidden-xs">Phone</th>
					<th class="text-center" style="width: 10%;">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php $count=1; ?>
				@foreach($all_guests as $guest)
				<tr>
					<td class="text-center">{{$count++}}</td>
					<td class="font-w600"><a href="#" data-toggle="modal" data-target="#modal-view{{$guest->id}}" title="View Guest">{{$guest->full_name}}</a></td>
					<td class="hidden-xs">{{$guest->email}}</td>
					<td class="hidden-xs">{{$guest->phone}}</td>
					<td class="text-center">
						<div class="btn-group">
                            @php
                                $deleteurl = route('guests-destroy',$guest->id);
                                // $successurl = route('settings-tab','users');
                            @endphp
							<div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view{{$guest->id}}" title="View Guest"> <i class="fa fa-eye"></i></a></div>
							{{-- <div style="display: inline-block;"><a href="/guests/{{$guest->id}}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Guest"> <i class="fa fa-edit"></i></a></div> --}}
							<div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Guest" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div>
						</div>
					</td>
				</tr>
			    <div class="modal fade" id="modal-view{{$guest->id}}" tabindex="-1" role="dialog" aria-hidden="true">

                    <div class="modal-dialog  modal-dialog-popout">
                        <div class="modal-content">
                            <div class="block block-themed block-transparent mb-0">
                                <div class="block-header bg-primary-dark">
                                    <h3 class="block-title">Guest Info</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                            <i class="si si-close"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content block-content-narrow">

									<div>
										<div class="form-group">
											<div class="">Full Name: <b>{{$guest->full_name}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Email: <b>{{$guest->email}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Phone: <b>{{$guest->phone}}</b></div>
										</div>
										<div class="form-group">
											<div class="">City: <b>{{$guest->city}}</b></div>
										</div>
										<div class="form-group">
											<div class="">Country: <b>{{$guest->country}}</b></div>
										</div>
									</div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                    <a href="{{route('reservations-create-guest',$guest->id)}}" class="btn btn-lg btn-primary"><i class="fa fa-calendar-check-o"></i> Make Reservation</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				@endforeach
			</tbody>
		</table>
    </div>
</div>
<!-- END Dynamic Table Full -->

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
