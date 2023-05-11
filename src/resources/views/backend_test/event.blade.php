<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div>id{{$event->id}}</div>
    <div>user_id{{$event->user_id}}</div>
    <div>title{{$event->title}}</div>
    <div>description{{$event->description}}</div>
    <div>date{{$event->date}}</div>
    <div>location{{$event->location}}</div>
    <div>slack_channel{{$event->slack_channel}}</div>
    <div>completed_at{{$event->completed_at}}</div>
    <div>request_id{{$event->request_id}}</div>
    <div>created_at{{$event->created_at}}</div>
    <div>updated_at{{$event->updated_at}}</div>
    <div>deleted_at{{$event->deleted_at}}</div>
    <div>event_participants_count{{$event->event_participants_count}}</div>
    <div>event_likes_count{{$event->event_likes_count}}</div>
    <div>isLiked{{$event->isLiked}}</div>
    <div>isParticipated{{$event->isParticipated}}</div>
    <!-- 主催者 -->
    @if($user->id=== $event->user_id)
    <form action="{{ route('events.destroy',['event'=>$event->id]) }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="submit" value="キャンセル">
    </form>
    <form action="{{ route('events.held',['event'=>$event->id]) }}" method="POST">
        @csrf
        <input type="submit" value="開催済み">
    </form>
    @endif
</body>

</html>