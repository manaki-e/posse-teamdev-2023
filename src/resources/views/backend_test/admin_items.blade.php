<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        @csrf
        <div>アイテム登録フォーム</div>
        <label>タイトル</label><input name='title'>
        <label>説明</label><input name='description'>
        <label>リクエストID</label><input name='request_id'>
        <input type="submit">
    </form>
    @foreach($not_pending_products as $product)
    <div style="display:flex;">
        <div>{{$product->title}}</div>
        <div>{{$product->point}}</div>
        <div>{{$product->japanese_product_status}} </div>
        <a href="/admin/items/{{$product->id}}">詳細</a>
        <a href="/admin/items/{{$product->id}}/edit">編集</a>
    </div>
    @endforeach
    @foreach($pending_products as $product)
    <div style="display:flex;">
        <div>{{$product->title}}</div>
        <div>{{$product->user->name}}</div>
        <a href="/admin/items/{{$product->id}}">詳細</a>
        <a href="/admin/items/{{$product->id}}/edit">編集</a>
    </div>
    @endforeach



</body>

</html>