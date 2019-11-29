@extends('layouts.app')

@section('content')
<div class="block block-themed">
    <div class="block-header bg-primary">
        <ul class="block-options">
            <li>
                <button type="button"><i class="si si-settings"></i></button>
            </li>
        </ul>
        <h3 class="block-title">Reservation Calendar</h3>
    </div>
    <div class="block-content">
        @if(isset($calendar_reservation))
            {!! $calendar_reservation->calendar() !!}
        @else
            {!! $all_calendar_reservations->calendar() !!}
        @endif
    </div>
</div>
@endsection
