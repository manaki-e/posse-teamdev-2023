<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- アイテム情報編集（ポイント設定しない） -->
    <form action="/admin/items/{{$product->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input name="form_type" value="update_product" hidden>
        <div>削除する画像を選択</div>
        @foreach($product->productImages as $product_image)
        <label>
            <img width="100" height="100" src=" {{asset('images/'.$product_image->image_url)}}">
            <input value="{{$product_image->id}}" type="checkbox" name="delete_images[]">
            {{ $product_image->image_url }}
        </label>
        @endforeach
        <div>
            追加する画像を選択
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
            @foreach($tags as $tag)
            <label>
                @if($tag->is_chosen===true)
                <input type="checkbox" name="product_tags[]" value="{{ $tag->id }}" checked>
                @else
                <input type="checkbox" name="product_tags[]" value="{{ $tag->id }}">
                @endif
                {{ $tag->name }}
            </label>
            @endforeach
        </div>
        <input type="submit" value="更新する">
    </form>
    <div>{{$product->japanese_product_status}}</div>
    <!-- ポイント設定して承認する -->
    <form action="/admin/items/{{$product->id}}" method="POST">
        @csrf
        @method('PUT')
        <input name=" form_type" value="set_point_and_approve" hidden>
        <div>
            <label>
                ポイント
                <input name="point" value="{{$product->point}}">
            </label>
        </div>
        <input type="submit" value="ポイント設定して承認する">
    </form>
    <!-- ポイント再設定する -->
    <form action="/admin/items/{{$product->id}}" method="POST">
        @csrf
        @method('PUT')
        <input name=" form_type" value="reset_point" hidden>
        <div>
            <label>
                ポイント
                <input name="point" value="{{$product->point}}">
            </label>
        </div>
        <input type="submit" value="ポイント再設定する">
    </form>
</body>

</html>