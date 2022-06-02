@if($list_product->isNotEmpty())
@foreach ($list_product as $item)
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <div class="card product-item border-0 mb-4">
        <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
            <img class="img-fluid" src="{{ asset($item->product_thumb) }}" alt="">
        </div>
        <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
            <h6 class="text-truncate mb-3">{{ $item->product_name }}</h6>
            <div class="d-flex justify-content-center">
                <h6>{{ currentcyFormat($item->product_price) }}</h6>
                <h6 class="text-muted ml-2"><del>{{ currentcyFormat($item->product_price) }}</del></h6>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-between bg-light border">
            <a href="{{ route('client.product.cat.show',$item->id) }}" class="btn btn-sm text-dark p-0"><i
                    class="fas fa-eye text-primary mr-1"></i>View
                Detail</a>
            <a href="" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To
                Cart</a>
        </div>
    </div>
</div>
@endforeach
@else
<div class="col-lg-3 col-md-6 col-sm-12 pb-1">
    <p>Không có dữ liệu.</p>
</div>
@endif
