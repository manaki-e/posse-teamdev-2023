<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- アイテム編集 -->
    <form action="/items/{{$product->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div>削除する画像を選択</div>
        @foreach($product->productImages as $product_image)
        <label>
            <img width="100" height="100" src=" {{asset('images/'.$product_image->image_url)}}">
            <input value="{{$product_image->id}}" type="checkbox" name="delete_images[]">
            {{ $product_image->image_url }}
        </label>
        @endforeach
        <div>
            <input type="file" name="product_images[]" multiple>
        </div>
        <div>
            <label>
                名前
                <input name="title" value="{{$product->title}}">
            </label>
        </div>
        <div>
            <label>
                備考
                <textarea cols="50" rows="4" name="description">{{ $product->description }}</textarea>
            </label>
        </div>
        <div>
            タグ
            @foreach($product_tags as $product_tag)
            <label>
                @if($product_tag->is_chosen===true)
                <input type="checkbox" name="delete_product_tags" value="{{ $product_tag->id }}" checked>
                @else
                <input type="checkbox" name="delete_product_tags" value="{{ $product_tag->id }}">
                @endif
                {{ $product_tag->name }}
            </label>
            @endforeach
        </div>
        <input type="submit">
    </form>
</body>

</html>