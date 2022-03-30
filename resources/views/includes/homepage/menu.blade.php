<header id="header" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 220, 'stickyChangeLogo': false}">
    <div class="header-body">
      <div class="header-container container">
        <div class="header-row">
          <div class="header-column">
            <div class="header-row">
              <div class="header-logo">
                <a href="{{route('home.index')}}">
                  <img alt="Porto" width="192" src="{{asset('homepage/assets/logo.png')}}">
                </a>
              </div>
            </div>
          </div>
          <div class="header-column justify-content-end">
            <div class="header-row">
              <div class="header-nav header-nav-stripe">
                <div class="header-nav-main header-nav-main-square header-nav-main-effect-1 header-nav-main-sub-effect-1">
                  <nav class="collapse">
                    <ul class="nav nav-pills" id="mainNav">
                      <li>
                        <a class="nav-link @if(Request::url() === route('home.index')) active @endif" href="{{route('home.index')}}">Home</a>
                      </li>
                      <li>
                        <a class="nav-link @if(Request::url() === route('home.about')) active @endif" href="{{route('home.about')}}">About</a>
                      </li>
                      <li>
                        <a class="nav-link @if(Request::url() === route('home.rooms')) active @endif" href="{{route('home.rooms')}}">
                          Rooms
                        </a>
                      </li>
                      <li>
                        <a class="nav-link @if(Request::url() === route('home.gallery')) active @endif" href="{{route('home.gallery')}}">
                          Gallery
                        </a>
                      </li>
                      <li>
                        <a class="nav-link @if(Request::url() === route('home.contact')) active @endif" href="{{route('home.contact')}}">
                          Contact Us
                        </a>
                      </li>
                      <li class="dropdown dropdown-full-color dropdown-primary dropdown-mega dropdown-mega-book-now" id="headerBookNow">
                        <a class="nav-link @if(Request::url() === route('home.reservation')) active @endif dropdown-toggle" href="{{route('home.reservation')}}">
                          Book Now
                        </a>
                        <ul class="dropdown-menu">
                          <li>
                            <div class="dropdown-mega-content">
                              <form id="bookFormHeader" action="{{route('home.reservation')}}" method="GET">
                                <div class="form-row">
                                  <div class="form-group col">
                                    <div class="form-control-custom form-control-datepicker-custom">
                                      <input type="text" value="" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Arrival" name="bookNowArrivalHeader" id="bookNowArrivalHeader" autocomplete="off" required>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col">
                                    <div class="form-control-custom form-control-datepicker-custom">
                                      <input type="text" value="" class="form-control text-uppercase text-2" data-msg-required="This field is required." placeholder="Departure" name="bookNowDepartureHeader" id="bookNowDepartureHeader" autocomplete="off" required>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col-lg-6">
                                    <div class="form-control-custom">
                                      <select class="form-control text-uppercase text-2" name="bookNowAdultsHeader" data-msg-required="This field is required." id="bookNowAdultsHeader" required>
                                        <option value="">Adults</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                      </select>
                                    </div>
                                  </div>
                                  <div class="form-group col-lg-6">
                                    <div class="form-control-custom">
                                      <select class="form-control text-uppercase text-2" name="bookNowKidsHeader" data-msg-required="This field is required." id="bookNowKidsHeader" required>
                                        <option value="">Kids</option>
                                        <option value="1">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                      </select>
                                    </div>
                                  </div>
                                </div>
                                <div class="form-row">
                                  <div class="form-group col mb-0">
                                    <input type="submit" value="Check availability" class="btn btn-secondary btn-lg btn-block text-uppercase text-2">
                                  </div>
                                </div>
                              </form>
                            </div>
                          </li>
                        </ul>
                      </li>
                    </ul>
                  </nav>
                </div>
                <button class="btn header-btn-collapse-nav" data-toggle="collapse" data-target=".header-nav-main nav">
                  <i class="fa fa-bars"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
