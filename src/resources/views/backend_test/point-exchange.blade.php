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
        {{$user->earned_point}}
    </div>
    <form action="{{route('point-exchange.store')}}" method="post">
        @csrf
        <label for="name">換金ポイント</label>
        <input type="text" id="name" name="point">
        <button type="submit">Submit</button>
    </form>
    {{-- Bladeテンプレート内でのエラーメッセージ表示 --}}
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif
</body>

</html>
