<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- アイテム詳細 -->
    <div>
        <a href="{{ route('items.index') }}">アイテム一覧</a>
        @foreach($product->productImages as $product_image)
        <img width="100" height="100" src=" {{asset('images/'.$product_image->image_url)}}">
        @endforeach
        <div>いいね{{$product->product_likes_count}}</div>
        <div>ステータス{{$product->japanese_status}}</div>
        <div>{{$product->point}}</div>
        <div>{{$product->title}}</div>
        <div>{!! $product->description !!}</div>
        <div>
            @foreach($product->productTags as $product_tag)
            <div>{{$product_tag->tag->name}}</div>
            @endforeach
        </div>
        <div>出品者{{$product->user->name}}</div>
        <form action="/items/{{$product->id}}" method="POST">
            @csrf
            @method('DELETE')
            アイテム削除フォーム
            <input type="submit" value="削除">
        </form>
        @if ($errors->has('not_enough_points'))
        <div class="alert alert-danger">
            {{ $errors->first('not_enough_points') }}
        </div>
        @endif
        @if($login_user_can_borrow_this_product)
        <form action="{{ route('items.borrow',['item'=>$product->id]) }}" method="POST">
            @csrf
            <input type="submit" value="借りる">
        </form>
        @endif
        @if($login_borrower_can_cancel_or_receive_this_product)
        <form action="{{ route('items.cancel',['item'=>$product->id]) }}" method="POST">
            @csrf
            <input type="submit" value="キャンセル">
        </form>
        <form action="{{ route('items.receive',['item'=>$product->id]) }}" method="POST">
            @csrf
            <input type="submit" value="受取完了">
        </form>
        @endif
        @if($login_lender_can_return_this_product)
        <form action="{{ route('items.return',['item'=>$product->id]) }}" method="POST">
            @csrf
            <input type="submit" value="返却完了">
        </form>
        @endif
    </div>
</body>

</html>