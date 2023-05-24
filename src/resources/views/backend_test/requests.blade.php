<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @foreach($requests as $request)
    <p>{{ $request->title }}</p>
    <p>{{ $request->description }}</p>
    <p>{{ $request->type_id }}</p>
    <p>{{ $request->user_id }}</p>
    <p>{{ $request->created_at }}</p>

    @endforeach
</body>

</html>