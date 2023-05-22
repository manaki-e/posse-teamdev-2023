<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="{{route('requests.store')}}">
        @csrf
        <div>
            <label>
                タイトル
                <input type="text" name="title">
            </label>
        </div>
        <div>
            <label>
                説明
                <textarea name="description" cols="50" rows="4"></textarea>
            </label>
        </div>
        <div>
            <label>
                タイプ
                <select name="type_id">
                    <option value="{{ $product_request_type_id }}">アイテム</option>
                    <option value="{{ $event_request_type_id }}">イベント</option>
                </select>
            </label>
        </div>
        <!-- select multiple tags from checkbox -->
        <div>
            <label>
                タグ
                <!-- create checkboxes -->
                <div>
                    @foreach($event_tags as $tag)
                    <label>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                    @endforeach
                </div>
                <div>
                    @foreach($product_tags as $tag)
                    <label>
                        <input type="checkbox" name="tags[]" value="{{ $tag->id }}">
                        {{ $tag->name }}
                    </label>
                    @endforeach
            </label>

            <input type="submit">
    </form>
</body>

</html>