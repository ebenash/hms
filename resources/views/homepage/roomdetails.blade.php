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

                    <h3 class="mt-4 pt-4 mb-0 pb-0 text-uppercase">{{$room->name}}</h3>
                    <div class="divider divider-primary divider-small mb-4 mt-0">
                        <hr class="mt-2 mr-auto">
                    </div>

                    <div class="row">
                        <div class="col-lg-7">

                            {{-- <p class="mt-4 lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultrices malesuada ante quis pharetra. Nullam non bibendum dolor. Ut vel turpis accumsan.</p> --}}

                            <p class="mt-4"><?=$room->description?></p>

                            <div class="room-suite-info">
                                <ul>
                                    <li><label>BEDS</label>	<span> {{$room->bed_type}}</span></li>
                                    <li><label>OCCUPANCY</label> <span>{{$room->max_persons}} Person(s)</span></li>
                                    <li><label>SIZE</label>	<span>{{$room->size}} sqm.</span></li>
                                    <li><label>RATES FROM</label> <strong>GHS {{$room->price_from}}</strong></li>
                                    <li>
                                        <a class="btn btn-primary btn-lg text-2 text-uppercase mt-2 room-suite-info-book-now" href="{{route('home.reservation')}}?ref={{$room->id}}">Book Now</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                        <div class="col-lg-5">

                            <div class="owl-carousel owl-theme nav-inside box-shadow-custom mt-4" data-plugin-options="{'items': 1, 'margin': 10, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 3000}">
                                @if($room->image_one)<div>
                                    <img src="{{asset($room->image_one)}}" class="img-fluid" alt="">
                                </div>@endif
                                @if($room->image_two)<div>
                                    <img src="{{asset($room->image_two)}}" class="img-fluid" alt="">
                                </div>@endif
                                @if($room->image_three)<div>
                                    <img src="{{asset($room->image_three)}}" class="img-fluid" alt="">
                                </div>@endif
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

@endsection
