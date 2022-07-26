<ul>
    {{-- @if($list_product->count() > 0) --}}
    @foreach ($list_product as $item)
    <li>
        <div class='img'>
            <a href="{{ route('client.product.detail',$item->id) }}"><img width="70px" height="70px"
                    src="{{ asset('storage/app/public/images/product/thumb/' . $item->product_details_thumb) }}"
                    alt=''></a>
        </div>
        <div class='info'>
            <a href="" class='name-product'>{{ $item->product_name }}</a>
            <p class='price'>{{ currentcyFormat($item->product_price - ($item->product_price * $item->product_discount)
                /
                100)}}</p>
        </div>
    </li>
    @endforeach
    {{-- <a href="{{ route('client.search') }}?key={{ $key }}" class='query-search'>Hiển thị kết quả cho
        <span>{{ $key }}</span></a>
    @else
    <li>
        <p>Không có sản phẩm nào</p>
    </li>
    @endif --}}
    <a href="{{ route('client.search') }}?key={{ $key }}" class='query-search'>Hiển thị kết quả cho
        <span>{{ $key }}</span></a>
</ul>
