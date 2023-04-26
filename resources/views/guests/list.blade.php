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

        @can('add guests')
            <div class="pull-right">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-guest"><i class="fa fa-plus"></i> Add New Guest</a>
            </div>
        @endcan
    </div>
    <div class="block-content block-content-full">
        <!-- DataTables init on table by adding .js-dataTable-full class, functionality is initialized in js/pages/tables_datatables.js -->

        <table class="table table-bordered table-striped table-vcenter js-dataTable-buttons">
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
				@php
                    $count=($all_guests->perPage()*($all_guests->currentPage() -1))+1;
                @endphp
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
                                @can('view guests')<div style="display: inline-block;"><a href="#" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-view{{$guest->id}}" title="View Guest"> <i class="fa fa-eye"></i></a></div> @endcan
                                @can('edit guests')<div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-edit{{$guest->id}}" title="View Guest"> <i class="fa fa-edit"></i></a></div> @endcan
                                @can('remove guests')<div style="display: inline-block;"><button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Guest" onclick="confimdelete('{{$deleteurl}}')"><i class="fa fa-times"> </i></button></div> @endcan
                            </div>
                        </td>
                    </tr>
                    @can('view guests')
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
                                                <div class="form-group js-gallery img-fluid-100">
                                                    ID On File
                                                    <div class="form-material input-group floating animated fadeIn">
                                                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{route('hms-guest-identification',($guest->id_card ?? 'no-id.jpg'))}}">
                                                            <div class="thumbnail" style="width: 200px; height: 70px;"><img src="{{route('hms-guest-identification',($guest->id_card ?? 'no-id.jpg'))}}" height="80px"/></div>
                                                        </a>
                                                    </div>
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
                                            @can('add reservations')<a href="{{route('reservations-create-guest',$guest->id)}}" class="btn btn-lg btn-primary"><i class="fa fa-address-book"></i> Make Reservation</a>@endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
                    @can('edit guests')
                        <div class="modal fade" id="modal-edit{{$guest->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog  modal-dialog-popout">
                                <div class="modal-content">
                                    <div class="block block-themed block-transparent mb-0">
                                        <div class="block-header bg-primary-dark">
                                            <h3 class="block-title">Update Guest Info</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                    <i class="si si-close"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-narrow">
                                            <form method="post" action="{{route('guests-update',$guest->id)}}" class="form-horizontal push-10-t" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="material-text2">Full Name <span class="text-danger" style="display: inline-block;">*</span></label>
                                                    <input type="text" name="full_name" class="form-control" value="{{$guest->full_name}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="material-text2">Email <span class="text-danger" style="display: inline-block;">*</span></label>
                                                    <input type="email" name="email" class="form-control" value="{{$guest->email}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="material-text2">Phone <span class="text-danger" style="display: inline-block;">*</span></label>
                                                    <input type="text" name="phone" class="form-control" value="{{$guest->phone}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="material-text2">ID Card <span class="text-danger" style="display: inline-block;">*</span></label>
                                                    <input type="file" name="id_card" class="form-control"{{$guest->id_card ? '' : 'required'}}>
                                                </div>
                                                <div class="form-group js-gallery img-fluid-100">
                                                    <label for="phone">ID On File</label>
                                                    <div class="form-material input-group floating animated fadeIn">
                                                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{route('hms-guest-identification',($guest->id_card ?? 'no-id.jpg'))}}">
                                                            <div class="thumbnail" style="width: 200px; height: 70px;"><img src="{{route('hms-guest-identification',($guest->id_card ?? 'no-id.jpg'))}}" height="80px"/></div>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="material-text2">City</label>
                                                    <input type="text" name="city" class="form-control" value="{{$guest->city}}">
                                                </div>

                                                {{-- <div class="form-group">
                                                    <label for="example2-select2">Country</label>
                                                    @include('includes.countries')
                                                </div> --}}
                                                <div class="form-group">
                                                    <label for="example-autocomplete2">Country</label>
                                                    <input class="js-autocomplete form-control" type="text" id="example-autocomplete2" name="country" value="{{$guest->country}}">
                                                </div>
                                                <div class="form-group text-right">
                                                    <button class="btn btn-lg btn-alt-primary" type="button" data-dismiss="modal">Close</button>
                                                    <button class="btn btn-lg btn-primary" type="submit">Update</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endcan
				@endforeach
			</tbody>
		</table>
                {{-- {{ $all_guests->links() }} --}}
    </div>
</div>
<!-- END Dynamic Table Full -->

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
    <script>jQuery(function(){One.helpers(['magnific-popup']);});</script>

    <script id="blockOfStuff" type="text/html">
        <div class="paginate" style="margin-left: auto;">
            {{$all_guests->onEachSide(1)->links()}}
        </div>
    </script>

    <script type="text/javascript">
        $(function () {
            $('#DataTables_Table_0_info').html("Page {{$all_guests->currentPage()}} of {{$all_guests->lastPage()}}");
            $('#DataTables_Table_0_paginate').html("");
            var div = document.createElement('div');
            // div.setAttribute('class', 'someClass');
            div.innerHTML = document.getElementById('blockOfStuff').innerHTML;
            document.getElementById('DataTables_Table_0_paginate').appendChild(div);
        });
    </script>

@endsection
