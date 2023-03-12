@extends('layouts.app')

@section('page-header')
    <h1 class="h3 font-w700 mb-2">
        Reservation Calendar
    </h1>
@endsection
@section('content')
<div class="block block-rounded">
    <div class="block-header">
        <h3 class="block-title">Calendar <small>View</small></h3>
        <div class="block-options">

            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle" onclick="resizecalendar()"></button>
            {{-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="pinned_toggle">
                <i class="si si-pin"></i>
            </button> --}}
            {{-- <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                <i class="si si-refresh"></i>
            </button> --}}
            <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
        </div>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-12">
                <?php $all_calendar_reservations = $helper->get_calendar($callendar_reservation_list); ?>
                @if(isset($calendar_reservation))
                    {!! $calendar_reservation->calendar() !!}
                @else
                    {!! $all_calendar_reservations->calendar() !!}
                    {!! $all_calendar_reservations->script() !!}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('js/plugins/fullcalendar/main.min.css') }}"/>
@endsection
@section('js_after')
    <!-- Page JS Plugins -->

    <script src="{{ asset('js/plugins/fullcalendar/main.js') }}"></script>
    <script src="{{ asset('js/plugins/fullcalendar/locales-all.min.js') }}"></script>

    <script>
        function resizecalendar() {
            $('.fc-col-header').css('width', '100%');
            $('.fc-daygrid-body').css('width', '100%');
            $('.fc-scrollgrid-sync-table').css('width', '100%');
        }
    </script>
@endsection
