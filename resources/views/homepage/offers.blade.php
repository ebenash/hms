@extends('layouts.homepage')

@section('content')
    <section class="page-header page-header-custom-background parallax section section-parallax section-center m-0 section-overlay-opacity section-overlay-opacity-scale-3" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="homepage/assets/img/reh/MG_8092.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="font-weight-bold text-light text-uppercase">Special Offers <span>Our Hotel Deals</span></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-background section-no-border m-0">
        <div class="container">
            <div class="row">
                <div class="col">
                    <span class="thumb-info thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom">
                        <span class="thumb-info-side-image-wrapper">
                            <img alt="" class="img-fluid" style="max-width: 340px;" src="img/demos/hotel/gallery/gallery-2.jpg">
                        </span>
                        <span class="thumb-info-caption">
                            <span class="thumb-info-caption-text">
                                <h4 class="text-uppercase mb-1">No Offers</h4>
                                <p>There are currently no deals on offer. Please check back later. </p>
                                <p class="text-right p-4 pb-0">
                                    <a class="btn btn-primary btn-lg text-2 text-uppercase mb-3" href="{{route('home.reservation')}}">Book Now <i class="icon-calendar icons ml-2"></i></a>
                                </p>
                            </span>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </section>

@endsection
