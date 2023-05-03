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
        <label>タイトル</label><input name='title'>
        <label>説明</label><input name='description'>
        <label>リクエストID</label><input name='request_id'>
        <input type="submit">
    </form>
</body>

</html>