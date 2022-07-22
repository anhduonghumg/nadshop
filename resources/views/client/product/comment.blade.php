<h4 class="mb-4">{{ $total_comment }} bình luận cho sản phẩm</h4>
@if($list_comment->isNotEmpty())
@foreach ($list_comment as $comment)
<div class="media mb-4">
    <img src="{{ asset('public/storage/images/logo_user.png') }}" alt="Image" class="img-fluid mr-3 mt-1"
        style="width: 45px;">
    <div class="media-body">
        <h6>{{ $comment->comment_name }}<small> - <i>{{ formatDateToDMY($comment->comment_date) }}</i></small></h6>
        <div class="text-primary mb-2">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
            <i class="far fa-star"></i>
        </div>
        <p>{{ $comment->comment }}</p>
    </div>
</div>
@endforeach
@else
<div class="media mb-4">
    <div class="media-body">
        <h6>Không có bình luận nào</h6>
    </div>
</div>
@endif
