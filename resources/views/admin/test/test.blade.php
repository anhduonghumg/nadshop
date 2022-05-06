@extends('layouts.admin')
@section('title','test')
@section('content')
<div class="row mt-3">
    <div class="col-md-5 mb-3">
        <label for="country">Country</label>
        <select class="custom-select d-block w-100" id="city" required="">
            <option value="">Chọn tỉnh/thành phố</option>
            @foreach ($city as $value)
            <option value="{{ $value->id }}">{{ $value->city_name }}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
            Please select a valid country.
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="state">State</label>
        <select class="custom-select d-block w-100" id="district" required="">
            <option value="">Chọn quận/huyện</option>
        </select>
        <div class="invalid-feedback">
            Please provide a valid state.
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('change','#city',function(e){
        let city = $('#city').val();
        $.ajax({
            url: "{{ route('test') }}",
            type: "GET",
            data: { city:city },
            dataType: "html",
            success: function (rsp) {
                $('#district').html(rsp);
            },error: function () {
           alert("error!!!!");
            },
        });
});

{{--  function show_html($result){
    let output = ``;
    output += `<option value="">Chọn quận/huyện</option>`;
    $.each($result, function (key, value) {
        output += `<option value="${value.id}">${value.district_name}</option>`;
    });
    $('#district').html(output);
}  --}}
</script>
@endsection
