<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>
        @foreach($product->productImages as $product_image)
        <img width="100" height="100" src=" {{asset('images/'.$product_image->image_url)}}">
        @endforeach
        <div>{{$product->title}}</div>
        <div>いいね{{$product->product_likes_count}}</div>
        <div>{{$product->point}}</div>
        <div>{!! $product->description !!}</div>
        <div>
            @foreach($product->productTags as $product_tag)
            <div>{{$product_tag->tag->name}}</div>
            @endforeach
        </div>
        <div>出品者{{$product->user->name}}</div>
    </div>
</body>

</html>