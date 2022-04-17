@extends('layouts.app')

@section('page-header')
<h1 class="flex-sm-fill h3 my-2">
    Search <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted"></small>
</h1>
@endsection

@section('content')
    <!-- Search -->
    <form action="{{route('global-search')}}" method="POST">
        @csrf
        <div class="input-group mb-5">
            <input type="text" class="form-control" placeholder="Search.." value="{{$keyword}}" name="keyword" id="keyword">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-fw fa-search"></i>
                </span>
            </div>
        </div>
    </form>
    <!-- END Search -->
    <!-- Results -->
    <div class="block block-rounded overflow-hidden">
        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#search-reservations">Reservations
                    <span class="badge badge-pill badge-primary">{{count($search_reservations)}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#search-guests">Guests
                    <span class="badge badge-pill badge-primary">{{count($search_guests)}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#search-rooms">Rooms
                    <span class="badge badge-pill badge-primary">{{count($search_rooms)}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#search-types">Room Types
                    <span class="badge badge-pill badge-primary">{{count($search_roomtypes)}}</span>
                </a>
            </li>
        </ul>
        <div class="block-content tab-content overflow-hidden">
            <!-- Projects -->
            <div class="tab-pane fade fade-up show active" id="search-reservations" role="tabpanel">
                <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light">
                    <span class="text-primary font-w700">{{count($search_reservations)}}</span> reservations found for <mark class="text-danger">{{$keyword}}</mark>
                </div>
                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Guest</th>
                            <th class="d-none d-lg-table-cell text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 20%;">Check-in</th>
                            <th class="text-center" style="width: 20%;">Check-out</th>
                            <th class="text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($search_reservations as $reservation)
                            <tr>
                                <td>
                                    <h4 class="h5 mt-3 mb-2">
                                        <a href="javascript:void(0)">{{$reservation->guest->full_name}}</a>
                                    </h4>
                                    <p class="d-none d-sm-block text-muted">
                                        Room: {{$reservation->room->name ?? 'Unassigned Room'}} ({{$reservation->roomtype->name ?? 'No Room Type'}})
                                    </p>
                                </td>
                                <td class="d-none d-lg-table-cell text-center">
                                    <span class="badge badge-{{$reservation->reservation_status == 'confirmed' ? 'success' : ($reservation->reservation_status == 'pending' ? 'warning' : 'danger')}}">{{$reservation->reservation_status}}</span>
                                </td>
                                <td class="d-none d-lg-table-cell font-size-xl text-center font-w600">{{date_format(new DateTime($reservation->check_in), 'jS F, Y')}}</td>
                                <td class="font-size-xl text-center font-w600">{{date_format(new DateTime($reservation->check_out), 'jS F, Y')}}</td>

                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route(($reservation->reservation_status == 'pending' ? 'reservations-view-request' : 'reservations-show'),$reservation->id)}}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Reservation">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        {{-- <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit Reservation">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END Projects -->

            <!-- Users -->
            <div class="tab-pane fade fade-up" id="search-guests" role="tabpanel">
                <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light">
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
                                        {{-- <div style="display: inline-block;"><a href="/guests/{{$guest->id}}/edit" class="btn btn-sm btn-warning" data-toggle="tooltip" title="Edit Guest"> <i class="fa fa-edit"></i></a></div>
                                        <div style="display: inline-block;"><form method="post" action="/guests/{{$guest->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-sm btn-danger" type="button" data-toggle="tooltip" title="Remove Client"><i class="fa fa-times"></i></button></form></div> --}}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END Users -->

            <!-- Classic -->
            <div class="tab-pane fade fade-up" id="search-rooms" role="tabpanel">
                <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light">
                    <span class="text-primary font-w700">{{count($search_rooms)}}</span> rooms found for <mark class="text-danger">{{$keyword}}</mark>
                </div>

                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Room Name</th>
                            <th class="hidden-sm">Room Type</th>
                            <th class="hidden-sm">Room Status</th>
                            {{-- <th class="text-center" style="width: 10%;">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @php $count=1; @endphp
                        @foreach($search_rooms as $room)
                            <tr>
                                <td class="d-none d-sm-table-cell text-center">
                                    <span class="badge badge-pill badge-primary">{{$count}}</span>
                                </td>
                                <td class="font-w600">{{$room->name}}</td>
                                <td class="hidden-sm">{{$room->roomtype->name ?? 'Undefined Room Type'}}</td>
                                <td class="hidden-sm">@if($room->status == 1) <span class="badge badge-success">Available</span>  @else <span class="badge badge-danger">Inactive</span> @endif</td>
                                <td class="text-center">
                                    {{-- <div class="btn-group">
                                        <div style="display: inline-block;"><a href="#" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#modal-edit{{$room->id}}" title="Edit Room"> <i class="fa fa-edit"></i> </a></div>
                                        <div style="display: inline-block;"><form method="post" action="/rooms/{{$room->id}}">{{ csrf_field() }} {{ method_field('DELETE')}}<button class="btn btn-sm btn-danger" type="submit" data-toggle="tooltip" title="Remove Room"><i class="fa fa-times"> </i></button></form></div>
                                    </div> --}}
                                </td>
                            </tr>
                            @php
                                $count++;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END Classic -->

            <!-- Photos -->
            <div class="tab-pane fade fade-up" id="search-types" role="tabpanel">
                <div class="font-size-h4 font-w600 p-2 mb-4 border-left border-4x border-primary bg-body-light">
                    <span class="text-primary font-w700">{{count($search_roomtypes)}}</span> room types found for <mark class="text-danger">{{$keyword}}</mark>
                </div>
                <table class="table table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th style="width: 40%;">Room Type Name</th>
                            <th class="d-none d-lg-table-cell text-center" style="width: 15%;">Price From</th>
                            <th class="text-center" style="width: 15%;">Max Persons</th>
                            <th class="text-center" style="width: 15%;">Bed Type</th>
                            <th class="text-center" style="width: 15%;">Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($search_roomtypes as $roomtype)
                            <tr>
                                <td>
                                    <h4 class="h5 mt-3 mb-2">
                                        <a href="javascript:void(0)">{{$roomtype->name ?? 'Undefined Room Type'}}</a>
                                    </h4>
                                    <p class="d-none d-sm-block text-muted">
                                        {{$roomtype->description}}
                                    </p>
                                </td>
                                <td class="d-none d-lg-table-cell text-center">
                                    {{$roomtype->price_from}}</span>
                                </td>
                                <td class="d-none d-lg-table-cell font-size-xl text-center font-w600">{{$roomtype->max_persons}}</td>
                                <td class="font-size-xl text-center font-w600">{{$roomtype->bed_type}}</td>
                                <td class="font-size-xl text-center font-w600">{{$roomtype->category}}</td>

                                {{-- <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{route(($roomtype->roomtype_status == 'pending' ? 'roomtypes-view-request' : 'roomtypes-show'),$roomtype->id)}}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Roomtype">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit Reservation">
                                            <i class="fa fa-pencil-alt"></i>
                                        </button>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- END Photos -->
        </div>
    </div>
    <!-- END Results -->
@endsection
