<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="/items" method="POST" enctype="multipart/form-data">
        @csrf
        <div>アイテム登録フォーム</div>
        <label>タイトル</label><input name='title'>
        <label>説明</label><input name='description'>
        <label>リクエストID</label><input name='request_id'>
        @foreach($product_tags as $product_tag)
        <label>
            <input name=" product_tags[]" type="checkbox" value="{{$product_tag->id}}">
            {{ $product_tag->name }}
        </label>
        @endforeach
        <input type="file" name="product_images[]" multiple>
        <input type="submit">
    </form>
    <div>絞り込み</div>
    <div style="display:flex;">
        <div>
            <div>
                利用状況
            </div>
            @foreach($japanese_product_statuses as $key=>$value)
            <label>
                <input type="radio" value="{{$key}}">
                {{ $value }}
            </label>
            @endforeach
        </div>
        <div>
            <div>
                カテゴリ
            </div>
            @foreach($product_tags as $key=>$value)
            <label>
                <input type="checkbox" value="{{$value->id}}">
                {{ $value->name }}
            </label>
            @endforeach
        </div>
    </div>
    <div style="display:flex;">
        @foreach($products as $product)
        <div>
            <div>{{$product->title}}</div>
            <div>{{$product->point}}</div>
            <div>{{$product->japanese_status}}</div>
            <img width="100" height="100" src=" {{asset('images/'.$product->productImages->first()->image_url)}}">
            <a href="/items/{{$product->id}}">詳細</a>
            <a href="/items/{{$product->id}}/edit">編集</a>
        </div>
        @endforeach
    </div>



</body>

</html>