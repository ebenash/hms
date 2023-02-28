@extends('layouts.homepage')

@section('content')
    <section class="page-header section section-primary section-no-border section-center page-header-custom-background m-0">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h1 class="font-weight-bold text-light text-uppercase">Locate Us <span>In the Heart of Elmina</span></h1>
                </div>
            </div>
        </div>
    </section>

    <div class="macro-map clearfix">
        <div class="macro-map-map">
            <div id="googleMapsMacro" class="google-map m-0" style="height: 400px;"></div>
        </div>
        <div class="macro-map-info">
            <div class="macro-map-info-detail">
                <i class="icon-location-pin icons text-color-primary mt-3"></i>
                <label>address</label>
                <strong>32 Ankaful Road,
                CK-0067-2921,
                Elmina</strong>
            </div>
            <div class="macro-map-info-detail">
                <i class="icon-phone icons text-color-primary mt-3"></i>
                <label>call us</label>
                <strong>+233 244 759 137</strong>
            </div>
            <div class="macro-map-info-detail">
                <i class="icon-envelope icons text-color-primary mt-3"></i>
                <label>email us</label>
                <strong>info@royalelmounthotel.com</strong>
            </div>
        </div>
    </div>


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

        const map = new google.maps.Map(document.getElementById("googleMapsMacro"), {
            center: position,
            zoom: 14,
            mapTypeControlOptions: {
            mapTypeIds: ["roadmap", "satellite", "hybrid", "terrain", "styled_map"],
            },
        });

        const infowindow = new google.maps.InfoWindow({
            content: "Royal Elount Hotel",
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
