@foreach($all_roomtypes as $roomtype)
    <option value="{{$roomtype->id}}" {{$room->room_type_id == $roomtype->id ? 'selected' : ''}}>{{$roomtype->name}}</option>
@endforeach
