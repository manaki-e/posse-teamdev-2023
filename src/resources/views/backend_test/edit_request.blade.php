<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('requests.update',$request->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input name="title" value="{{ $request->title }}">
        <input name="description" value="{{ $request->description }}">
        <select name="type_id">
            <option value="{{ $product_request_type_id }}">アイテム</option>
            <option value="{{ $event_request_type_id }}">イベント</option>
        </select>
        @foreach($event_tags as $tag) <label>
            <input type="checkbox" name="event_tags[]" value="{{ $tag->id }}" @if($tag->checked) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach
        @foreach($product_tags as $tag)
        <label>
            <input type="checkbox" name="product_tags[]" value="{{ $tag->id }}" @if($tag->checked) checked @endif>
            {{ $tag->name }}
        </label>
        @endforeach



        <input type="submit" value="更新">
    </form>
</body>

</html>