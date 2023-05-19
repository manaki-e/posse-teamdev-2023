<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('events.store') }}" method="POST">
        @csrf
        <label>タイトル：<input name="title" required></label>
        <label>説明：<textarea name="description" required></textarea></label>
        <label>日時：<input type="datetime-local" name="date"></label>
        <label>場所(オンラインか住所)：<input name="location"></label>
        <label>
            対応リクエスト
            <select name="request_id">
                <option value="null">対応リクエストなし</option>
                @foreach($requests as $request)
                <option value="{{ $request->id }}">{{ $request->title }}</option>
                @endforeach
            </select>
        </label>
        <label>
            タグ
            @foreach($tags as $tag)
            <label>
                <input name="tags[]" type="checkbox" value="{{$tag->id}}">
                {{$tag->name}}
            </label>
            @endforeach
        </label>
        <input type="submit">
    </form>

</body>

</html>