<option value="">Chọn quận/huyện</option>
@foreach ($district as $value)
<option value="{{ $value->id }}">{{ $value->district_name }}</option>
@endforeach
