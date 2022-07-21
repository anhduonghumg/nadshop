<div class="row px-xl-5 pb-3">
    @if ($list_product->isNotEmpty())
        @foreach ($list_product as $item)
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <img class="img-fluid" src="{{ asset($item->product_thumb) }}" alt="">
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3">{{ $item->product_name }}</h6>
                        <div class="d-flex justify-content-center">
                            <h6>{{ currentcyFormat($item->product_price - ($item->product_price * $item->product_discount) / 100) }}
                            </h6>
                            <h6 class="text-muted ml-2">
                                <del>{{ currentcyFormat($item->product_price) }}</del>
                            </h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="{{ route('client.product.detail', $item->id) }}" data-id="{{ $item->id }}"
                            data-name="{{ $item->product_name }}" data-img="{{ $item->product_thumb }}"
                            data-url="{{ route('client.product.detail', $item->id) }}"
                            data-price="{{ $item->product_price - ($item->product_price * $item->product_discount) / 100 }}"
                            class="btn btn-sm text-dark p-0 btn_view"><i class="fas fa-eye text-primary mr-1"></i>Xem
                            chi
                            tiết</a>
                        <a href="" class="btn btn-sm text-dark p-0 btn_buy_now" data-id="{{ $item->id }}"><i
                                class="fas fa-shopping-cart text-primary mr-1"></i>Mua ngay</a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
{{ $list_product->links('layouts.paginationlink') }}
