<option value="">Quận/Huyện</option>
@if($list_district->isNotEmpty())
@foreach ($list_district as $district )
<option value="{{$district->id }}">{{ $district->district_name }}</option>
@endforeach
@endif
