<ul class="product_best_sell">
    @foreach ($list_product as $item)
        <li>
            <div class='img'>
                <a href="#"><img
                        src="{{ asset('storage/app/public/images/product/thumb/' . $item->product_details_thumb) }}"
                        alt=''></a>
            </div>
            <div class='info'>
                <a href="#" class='name-product'>{{ $item->product_name }}</a>
                {{-- <p class='price'>
                    {{ currentcyFormat($item->product_price - ($item->product_price * $item->product_discount) / 100) }}
                </p> --}}
                <p class='qty_sell'>Lượt xem: <span>{{ $item->view }}<span></p>
            </div>
        </li>
    @endforeach
</ul>
