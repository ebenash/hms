@extends('layouts.homepage')

@section('content')
    <div class="slider-container rev_slider_wrapper" style="height: 530px;">
        <div id="revolutionSlider" class="slider rev_slider manual">
            <ul>
                <li data-transition="boxfade">

                    <img src="{{asset('homepage/assets/img/hotel/slides/el_slide1.jpg')}}" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                </li>
                <li data-transition="boxfade">

                    <img src="{{asset('homepage/assets/img/hotel/slides/el_slide2.jpg')}}" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                </li>
                <li data-transition="boxfade">

                    <img src="{{asset('homepage/assets/img/hotel/slides/el_slide3.jpeg')}}" alt="" data-bgposition="top bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                </li>
                <li data-transition="boxfade">

                    <img src="{{asset('homepage/assets/img/hotel/slides/el_slide4.jpg')}}" alt="" data-bgposition="center bottom" data-bgfit="cover" data-bgrepeat="no-repeat" data-bgparallax="10" class="rev-slidebg" data-no-retina>
                </li>
            </ul>
        </div>
    </div>

    <section class="section section-no-background section-no-border m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">

                    <h3 class="mt-4 mb-0 pb-0 text-uppercase">Welcome To Royal Elmount Hotel</h3>
                    <div class="divider divider-primary divider-small mb-4 mt-0">
                        <hr class="mt-2 mr-auto">
                    </div>

                    <p class="lead">World-Class Amenities and Authentic Ghanaian Hospitality</p>

                    <p class="mt-4">The Royal Elmount Hotel has been designed to channel both modern, elegant sophistication and the peaceful, natural beauty of the historic town of Elmina. </p>

                    <a class="btn btn-primary btn-lg text-2 text-uppercase mt-2 mb-4" href="{{route('home.about')}}">Learn More</a>
                </div>
                <div class="col-lg-6">

                    <div class="micro-map box-shadow-custom clearfix">
                        <div class="micro-map-map">
                            <div ref="googleMapsMicro" id="googleMapsMicro" class="google-map m-0" style="height: 280px;"></div>
                        </div>
                        <div class="micro-map-info">
                            <div class="micro-map-info-detail">
                                <i class="icon-location-pin icons text-color-primary"></i>
                                <label>address</label>
                                <strong>Royal Elmount Hotel, Porto, Elmina, Ghana</strong>
                                <a href="https://www.google.com/maps/search/?api=1&query=royal+elmount+hotel" title="" target="blank">(View Location)</a>
                            </div>
                            <div class="micro-map-info-detail">
                                <i class="icon-phone icons text-color-primary"></i>
                                <label>call us</label>
                                <strong>+233 20 004 3929</strong>
                                <strong>+233 20 004 3979</strong>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section class="parallax section section-parallax section-center m-0 section-overlay-opacity section-overlay-opacity-scale-4" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="{{asset('homepage/assets/img/reh/MG_8661.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="mb-1 mt-0 text-light text-uppercase">Authentic Ghanaian Hospitality</h3>
                    <p class="lead text-light mb-4">Make your reservation right now and experience the best of Elmina</p>

                    <a class="btn btn-primary btn-lg text-2 text-uppercase mt-2" href="{{route('home.reservation')}}">Book Now</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-background section-no-border m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">

                    <div class="owl-carousel owl-theme nav-inside box-shadow-custom mt-4" data-plugin-options="{'items': 1, 'margin': 10, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 3000}">
                        <div>
                            <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/MG_8092_alt.jpg')}}">
                        </div>
                        <div>
                            <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/MG_8444_alt.jpg')}}">
                        </div>
                        <div>
                            <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/MG_8545_alt.jpg')}}">
                        </div>
                        <div>
                            <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/MG_8586_alt.jpg')}}">
                        </div>
                    </div>

                </div>
                <div class="col-lg-8">

                    <h3 class="mt-4 mb-0 pb-0 text-uppercase">World-Class Amenities</h3>
                    <div class="divider divider-primary divider-small mb-4 mt-0">
                        <hr class="mt-2 mr-auto">
                    </div>

                    <p class="mt-4">Jacuzzi, Private Balconies, Leather Recliners, Free Wi-fi, and Wall-Mounted Safes are only a few of the amenities that we offer our esteemed guests. <!--<a href="{{route('home.about')}}" class="custom-rtl-link-fix" title="">(View More...)</a></p>-->

                    <div class="row">
                        <div class="col-lg-4">
                            <ul class="list list-icons list-primary list-borders text-uppercase text-color-dark text-2">
                                <li><i class="fa fa-check"></i> 41 Rooms, 4 Luxury suites</li>
                                <li><i class="fa fa-check"></i> Room service</li>
                                <li><i class="fa fa-check"></i> Private Balconies</li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list list-icons list-primary list-borders text-uppercase text-color-dark text-2">
                                <li><i class="fa fa-check"></i> 24-hour security</li>
                                <li><i class="fa fa-check"></i> Plush Green Lawn</li>
                                {{-- <li><i class="fa fa-check"></i> Cocktail Bar</li> --}}
                                <li><i class="fa fa-check"></i> Accessible parking</li>
                            </ul>
                        </div>
                        <div class="col-lg-4">
                            <ul class="list list-icons list-primary list-borders text-uppercase text-color-dark text-2">
                                <li><i class="fa fa-check"></i> Wall-Mounted Safes</li>
                                <li><i class="fa fa-check"></i> Pool</li>
                                <li><i class="fa fa-check"></i> Free Wi-Fi</li>
                            </ul>
                        </div>
                    </div>

                </div>


            </div>
        </div>
    </section>

    {{-- <section class="section section-text-light section-background section-center section-overlay-opacity section-overlay-opacity-scale-4 m-0" style="background-image: url(homepage/assets/img/demos/hotel/video-cover-bg-1.jpg);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12" style="height: 360px;">
                    <a href="https://www.youtube.com/embed/muaykuehU0k" class="play-video-custom"><img src="{{asset('homepage/assets/img/demos/hotel/play-icon.png')}}" class="img-fluid" width="90" height="90" /></a>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="section section-primary section-no-border m-0" data-plugin-parallax data-plugin-options="{'speed': 6}" data-image-src="{{asset('homepage/assets/img/demos/hotel/parallax-hotel-map.png')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h3 class="mt-4 mb-0 pb-0 text-light text-uppercase">What’s Nearby</h3>
                    <div class="divider divider-light divider-small divider-small-center mb-4 mt-0">
                        <hr class="mt-2">
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="testimonial testimonial-style-3 testimonial-style-custom appear-animation" data-appear-animation="fadeInUp" data-appear-animation-delay="0">
                        <span class="thumb-info thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom thumb-info-no-zoom thumb-info-side-image-custom-highlight appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="0">
                            <span class="thumb-info-side-image-wrapper">
                                <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/elcastle.jpg')}}">
                            </span>
                            <span class="thumb-info-caption">
                                <span class="thumb-info-caption-text">
                                    <h4 class="text-dark">Places to Visit</h4>
                                    <ul class="list list-icons list-primary">
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="0"><i class="fa fa-check"></i> Elmina Castle</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="300"><i class="fa fa-check"></i> Kakum National Park</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="600"><i class="fa fa-check"></i> Elmina Beach</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="1200"><i class="fa fa-check"></i> Cape Coast Castle</li>
									</ul>
                                </span>
                            </span>
                        </span>
                        {{-- <div class="testimonial-arrow-down mx-auto"></div>
                        <div class="testimonial-author">
                            <p><strong>Places to Visit</strong><span>Porto Advisor</span></p>
                        </div> --}}
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial testimonial-style-3 testimonial-style-custom appear-animation" data-appear-animation="fadeInUp" data-appear-animation-delay="300">
                        <span class="thumb-info thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom thumb-info-no-zoom thumb-info-side-image-custom-highlight appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="0">
                            <span class="thumb-info-side-image-wrapper">
                                <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/culture.jpg')}}">
                            </span>
                            <span class="thumb-info-caption">
                                <span class="thumb-info-caption-text">
                                    <h4 class="text-dark">The Culture</h4>
                                    <ul class="list list-icons list-primary">
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="0"><i class="fa fa-check"></i> Bakatue Festival</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="300"><i class="fa fa-check"></i> Fetu Afahye Festival</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="600"><i class="fa fa-check"></i> Panafest</li>
										<li class="appear-animation animated fadeInUp appear-animation-visible" data-appear-animation="fadeInUp" data-appear-animation-delay="1200"><i class="fa fa-check"></i> Return of the African Disapora</li>
									</ul>
                                </span>
                            </span>
                        </span>
                        {{-- <div class="testimonial-arrow-down mx-auto"></div>
                        <div class="testimonial-author">
                            <p><strong>Brad Smith</strong><span>Porto Advisor</span></p>
                        </div> --}}
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="section section-no-background section-no-border m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">

                    <h3 class="mb-0 pb-0 text-uppercase">Gallery</h3>
                    <div class="divider divider-primary divider-small divider-small-center mb-4 mt-0">
                        <hr class="mt-2">
                    </div>

                    <div class="row pt-4">
                        <div class="col-lg-6">

                            <span class="thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom thumb-info-no-zoom thumb-info-side-image-custom-highlight appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="0">
                                <span class="thumb-info-side-image-wrapper">
                                    <img alt="" class="img-fluid" src="{{asset('homepage/assets/img/reh/MG_8121.jpg')}}">
                                </span>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <div>
                                <span class="thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300">
                                    <span class="thumb-info-side-image-wrapper">
                                        <img alt="" class="img-fluid mb-4" style="max-width: 225px;" src="{{asset('homepage/assets/img/reh/MG_8217.jpg')}}">
                                    </span>
                                </span>
                                <span class="thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="600">
                                    <span class="thumb-info-side-image-wrapper">
                                        <img alt="" class="img-fluid mb-4" style="max-width: 225px;" src="{{asset('homepage/assets/img/reh/IMG_3943.jpeg')}}"><!--MG_8244.jpg-->
                                    </span>
                                </span>
                            </div>
                            <div>
                                <span class="thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300">
                                    <span class="thumb-info-side-image-wrapper">
                                        <img alt="" class="img-fluid" style="max-width: 225px;" src="{{asset('homepage/assets/img/reh/MG_8573.jpg')}}">
                                    </span>
                                </span>
                                <span class="thumb-info-side-image thumb-info-side-image-custom thumb-info-no-zoom box-shadow-custom appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="600">
                                    <span class="thumb-info-side-image-wrapper">
                                        <img alt="" class="img-fluid" style="max-width: 225px;" src="{{asset('homepage/assets/img/reh/MG_8539.jpg')}}">
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <a class="btn btn-primary btn-lg text-2 text-uppercase mt-2" href="{{route('home.gallery')}}">View All</a>

                </div>

            </div>
        </div>
    </section>

@endsection


@push('script_after')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCxMIw8V1fn7gZG2tN6fFsELMwyberp3QI"></script>
    <script>


        // Map Initial Location
        var position = { lat: 5.107721475226887, lng: -1.3399243472390006 };

        // Styles from https://snazzymaps.com/
        var styles = [{
            "featureType": "water",
            "elementType": "geometry",
            "stylers": [{
                "color": "#e9e9e9"
            }, {
                "lightness": 17
            }]
        }, {
            "featureType": "landscape",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }, {
                "lightness": 20
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 17
            }]
        }, {
            "featureType": "road.highway",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 29
            }, {
                "weight": 0.2
            }]
        }, {
            "featureType": "road.arterial",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 18
            }]
        }, {
            "featureType": "road.local",
            "elementType": "geometry",
            "stylers": [{
                "color": "#ffffff"
            }, {
                "lightness": 16
            }]
        }, {
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f5f5f5"
            }, {
                "lightness": 21
            }]
        }, {
            "featureType": "poi.park",
            "elementType": "geometry",
            "stylers": [{
                "color": "#dedede"
            }, {
                "lightness": 21
            }]
        }, {
            "elementType": "labels.text.stroke",
            "stylers": [{
                "visibility": "on"
            }, {
                "color": "#ffffff"
            }, {
                "lightness": 16
            }]
        }, {
            "elementType": "labels.text.fill",
            "stylers": [{
                "saturation": 36
            }, {
                "color": "#333333"
            }, {
                "lightness": 40
            }]
        }, {
            "elementType": "labels.icon",
            "stylers": [{
                "visibility": "off"
            }]
        }, {
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [{
                "color": "#f2f2f2"
            }, {
                "lightness": 19
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#fefefe"
            }, {
                "lightness": 20
            }]
        }, {
            "featureType": "administrative",
            "elementType": "geometry.stroke",
            "stylers": [{
                "color": "#fefefe"
            }, {
                "lightness": 17
            }, {
                "weight": 1.2
            }]
        }];

        var styledMap = new google.maps.StyledMapType(styles, {
            name: 'Styled Map'
        });

        const map = new google.maps.Map(document.getElementById("googleMapsMicro"), {
            center: position,
            zoom: 14,
            disableDefaultUI: true,
        });

        const infowindow = new google.maps.InfoWindow({
            content: "Royal Elmount Hotel",
        });
        // Map Markers
        var mapMarkers = {
            // address: "Royal Elmount Hotel, Ankaful Road, Elmina",
            position: position,
            map,
            icon: "homepage/assets/img/pin.png",
            title: "Royal Elmount Hotel, Ankaful Road, Elmina"
        };

        map.mapTypes.set('styled_map', styledMap);
        map.setMapTypeId('styled_map');

        const image =
        "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
        const marker = new google.maps.Marker(mapMarkers);

        marker.addListener("click", () => {
            infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
            });
        });
    </script>
@endpush

