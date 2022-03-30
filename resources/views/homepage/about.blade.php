@extends('layouts.homepage')

@section('content')
    <section class="page-header page-header-custom-background parallax section section-parallax section-center m-0 section-overlay-opacity section-overlay-opacity-scale-3" data-plugin-parallax data-plugin-options="{'speed': 1.5}" data-image-src="homepage/assets/img/reh/MG_8539.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="font-weight-bold text-light text-uppercase">We are  Royal Elmount
                        Hotel & Resort<span>Where Hospitality Meets Class</span></h1>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-no-background section-no-border m-0">
        <div class="container">
            <div class="row mb-4">

                <div class="col-lg-3">
                    <div class="tabs tabs-vertical tabs-left tabs-navigation">
                        <ul class="nav nav-tabs col-sm-3">
                            <li class="nav-item active">
                                <a class="nav-link" href="#tabsNavigation1" data-toggle="tab"> Overview</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#tabsNavigation2" data-toggle="tab"> FAQ's</a>
                            </li>
                        </ul>
                    </div>

                    {{-- <a href="{{route('home.offers')}}" class="mt-4 mb-4 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="0" title="">
                        <img alt="" class="img-fluid mt-2 mt-lg-4 mb-4" src="homepage/assets/img/reh/banner-hotel.jpg">
                    </a> --}}
                </div>
                <div class="col-lg-9">
                    <div class="tab-pane tab-pane-navigation active" id="tabsNavigation1">

                        <h3 class="mb-0 pb-0 text-uppercase">A Unique and Authentic Elmina Experience Like No Other…</h3>
                        <div class="divider divider-primary divider-small mb-4 mt-0">
                            <hr class="mt-2 mr-auto">
                        </div>

                        <div class="row">
                            <div class="col-lg-8">

                                <p class="lead">The Royal Elmount Hotel has been designed to channel both modern, elegant sophistication and the peaceful, natural beauty of the historic town of Elmina. </p>

                                <p class="mt-4">
                                    Royal Elmount Hotel sits atop a hilly range in the heart of the Elmina, providing a bird’s-eye view of the entire surrounding town and its virgin greenery, as well as Elmina’s magnificent coastal line merging with the Atlantic Ocean.
                                </p>
                                <p class="mt-4">
                                    The Hotel’s elevation also provides fresher air and gentle sea breezes during the day, and cooler temperatures to relax guests at night. Our rooms are fitted with world-class amenities to ensure a comfortable stay— you can enjoy a hot, continental breakfast on your private balcony while watching the exotic birds that frequent the hotel grounds every morning, or soak in a luxurious Jacuzzi bath at the end of a long day exploring Elmina.
                                </p>
                                <p class="mt-4">
                                    The Hotel is conveniently proximate to important tourism and commercial hubs: 10-minute drive to the Elmina Castle; 13-minute drive to the University of Cape Coast; 6-minute drive to the beach; 18-minute drive to the famous Kotokuraba Market, etc. Whatever your plans or arrangements are, the Royal Elmount Team is  happy to offer any kind of assistance in bringing your plans to reality.
                                </p>
                                <p class="mt-4">
                                    The Hotel’s staff and management personnel are native Elminians who are incredibly proud to welcome all guests from near and far to experience the rich cultural heritage, natural beauty, and warm hospitality of the town and its inhabitants.
                                </p>

                            </div>
                            <div class="col-lg-4">

                                <div class="owl-carousel owl-theme nav-inside box-shadow-custom mt-4" data-plugin-options="{'items': 1, 'margin': 10, 'animateOut': 'fadeOut', 'autoplay': true, 'autoplayTimeout': 3000}">
                                    <div>
                                        <img alt="" class="img-fluid" src="homepage/assets/img/reh/MG_8094.jpg">
                                    </div>
                                    <div>
                                        <img alt="" class="img-fluid" src="homepage/assets/img/reh/MG_8664.jpg">
                                    </div>
                                    <div>
                                        <img alt="" class="img-fluid" src="homepage/assets/img/reh/MG_8605.jpg">
                                    </div>
                                    <div>
                                        <img alt="" class="img-fluid" src="homepage/assets/img/reh/MG_8573.jpg">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row mt-4">
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
                    <div class="tab-pane tab-pane-navigation" id="tabsNavigation2">

                        <h3 class="mb-0 pb-0 text-uppercase">Frequently Asked Questions</h3>
                        <div class="divider divider-primary divider-small mb-4 mt-0">
                            <hr class="mt-2 mr-auto">
                        </div>

                        <div class="row">
                            <div class="col">

                                <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non bibendum dolor. Ut vel turpis accumsan.</p>

                                <p class="mt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer ultrices malesuada ante quis pharetra. Nullam non bibendum dolor. Ut vel turpis accumsan, efficitur dolor fermentum, tincidunt metus ut vel turpis accumsan.</p>

                            </div>
                        </div>

                        <div class="toggle toggle-primary" data-plugin-toggle>
                            <section class="toggle">
                                <label>What are the check-in and check-out times at Royal Elmount Hotel?</label>
                                <p>Check-in at Royal Elmount Hotel is from 12:00 PM, and check-out is until 12:00 PM.</p>
                            </section>

                            <section class="toggle">
                                <label>How far is Royal Elmount Hotel from the center of Elmina?</label>
                                <p>Royal Elmount Hotel is 3 km from the center of Elmina.</p>
                            </section>

                            <section class="toggle">
                                <label>Does Royal Elmount Hotel have a pool?</label>
                                <p>Yes, this hotel has a pool.</p>
                            </section>

                            <section class="toggle">
                                <label>What type of room can I book at Royal Elmount Hotel?</label>
                                <p>Room options at Royal Elmount Hotel include:

                                    Suite,
                                    Twin/Double,
                                    Twin,
                                    Double</p>
                            </section>

                            <section class="toggle">
                                <label>How much does it cost to stay at Royal Elmount Hotel?</label>
                                <p>
                                    The prices at Royal Elmount Hotel may vary depending on your stay (e.g. dates, hotel's policy etc.). To see prices, enter your dates.</p>
                            </section>

                            {{-- <section class="toggle">
                                <label>Curabitur eget leo at velit imperdiet varius iaculis vitaes?</label>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
                            </section>

                            <section class="toggle">
                                <label>Curabitur eget leo at velit imperdiet vague iaculis vitaes?</label>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
                            </section>

                            <section class="toggle">
                                <label>Curabitur eget leo at velit imperdiet viaculis vitaes?</label>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa.</p>
                            </section>

                            <section class="toggle">
                                <label>Curabitur eget leo at velit imperdiet varius iaculis vitaes?</label>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eget leo at velit imperdiet varius. In eu ipsum vitae velit congue iaculis vitae at risus. Nullam tortor nunc, bibendum vitae semper a, volutpat eget massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer fringilla, orci sit amet posuere auctor, orci eros pellentesque odio, nec pellentesque erat ligula nec massa. Aenean consequat lorem ut felis ullamcorper posuere gravida tellus faucibus. Maecenas dolor elit, pulvinar eu vehicula eu, consequat et lacus. Duis et purus ipsum. In auctor mattis ipsum id molestie. Donec risus nulla, fringilla a rhoncus vitae, semper a massa. Vivamus ullamcorper, enim sit amet consequat laoreet, tortor tortor dictum urna, ut egestas urna ipsum nec libero. Nulla justo leo, molestie vel tempor nec, egestas at massa. Aenean pulvinar, felis porttitor iaculis pulvinar, odio orci sodales odio, ac pulvinar felis quam sit.</p>
                            </section> --}}
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
