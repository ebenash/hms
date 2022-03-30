<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (isset($main_company->logo))
<img src="{{route('hms-uploads-file',($main_company->logo ?? 'mist_logo.jpeg'))}}" width="150px" alt="{{$main_company->name}}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
