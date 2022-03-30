@extends('layouts.homepage')

@section('content')
    <section class="page-header section section-primary section-no-border section-center page-header-custom-background m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="font-weight-bold text-light text-uppercase">Rooms <span>Check out our amazing options</span></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-background section-no-border m-0 p-0">
        <div class="container">
            <div class="row mb-4">

                <div class="col">

                    <div class="row">
                        <div class="col d-flex justify-content-center">
                            <ul class="nav nav-pills nav-pills-center sort-source text-2 text-uppercase my-4 py-2" data-sort-id="portfolio" data-option-key="filter" data-plugin-options="{'layoutMode': 'fitRows', 'filter': '*'}">
                                <li class="nav-item active" data-option-value="*"><a class="nav-link active" href="#">Show All</a></li>
                                <li class="nav-item" data-option-value=".room"><a class="nav-link" href="#">Rooms</a></li>
                                <li class="nav-item" data-option-value=".suite"><a class="nav-link" href="#">Suites</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="sort-destination-loader sort-destination-loader-showing">
                        <div class="row mb-4 portfolio-list sort-destination" data-sort-id="portfolio">
                            @foreach ($rooms as $room)
                                <div class="col-md-6 col-lg-4 isotope-item {{$room->category}} mb-4 pb-3">
                                    <a href="{{route('home.roomdetails',$room->name)}}">
                                        <span class="thumb-info thumb-info-centered-info thumb-info-no-borders">
                                            <span class="thumb-info-wrapper">
                                                <img src="{{asset($room->image_one ?? 'homepage/assets/img/demos/hotel/room-1.jpg')}}" class="img-fluid" alt="">
                                                <span class="thumb-info-title">
                                                    <span class="thumb-info-inner">View Details</span>
                                                </span>
                                            </span>
                                        </span>
                                    </a>
                                    <h5 class="mt-3 mb-0">{{$room->name}}</h5>
                                    <div class="room-suite-info">
                                        <ul>
                                            <li><label>BEDS</label>	<span> {{$room->bed_type}}</span></li>
                                            <li><label>OCCUPANCY</label> <span>{{$room->max_persons}} Person(s)</span></li>
                                            <li><label>SIZE</label>	<span>{{$room->size}} sqm.</span></li>
                                            <li><label>RATES FROM</label> <strong>GHS {{$room->price_from}}</strong></li>
                                            <li>
                                                <a href="{{route('home.roomdetails',$room->name)}}" class="room-suite-info-detail" title="">View Details <i class="fa fa-long-arrow-right"></i></a>
                                                <a href="{{route('home.reservation')}}?ref={{$room->id}}" class="room-suite-info-book" title="">Book Now</i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
