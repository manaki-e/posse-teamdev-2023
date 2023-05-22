<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>{{ $request->title }}</div>
    <div>{{ $request->description }}</div>
    <div>{{ $request->type_id }}</div>
    <div>{{ $request->user_id }}</div>
    <div>{{ $request->created_at }}</div>
    <form action="{{ route('requests.destroy',$request->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="削除">
    </form>
</body>

</html>