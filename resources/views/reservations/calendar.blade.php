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
        <div class="pull-left">
			<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-view-add-reservation"><i class="fa fa-plus"></i> Add New Reservation</a>
		</div>
        <br/><br/>
        <?php $all_calendar_reservations = Calendar::addEvents($callendar_reservation_list); ?>
        @if(isset($calendar_reservation))
            {!! $calendar_reservation->calendar() !!}
        @else
            {!! $all_calendar_reservations->calendar() !!}
        @endif
    </div>
</div>
@endsection
