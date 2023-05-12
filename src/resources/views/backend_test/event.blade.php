<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @if ($errors->has('not_enough_point'))
    <div class="alert alert-danger">
        {{ $errors->first('not_enough_point') }}
    </div>
    @endif
    <div>所持消費ポイント{{$user->distribution_point}}</div>
    <div>id{{$event->id}}</div>
    <div>user_id{{$event->user_id}}</div>
    <form action="{{ route('events.update',['event'=>$event->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- 編集できる項目これで大丈夫？ -->
        <input name="title" value="{{$event->title}}">
        <textarea cols="50" rows="4" name="description">{{ $event->description }}</textarea>
        <input type="datetime-local" name="date" value="{{$event->date}}">
        <input name="location" value="{{$event->location}}">
        <input type="submit" value="編集する">
    </form>
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
    @if($user->id=== $event->user_id&&$event->completed_at===null)
    <form action=" {{ route('events.destroy',['event'=>$event->id]) }}" method="POST">
        @csrf
        @method(' DELETE') <input type="submit" value="開催キャンセル">
    </form>
    <form action="{{ route('events.held',['event'=>$event->id]) }}" method="POST">
        @csrf
        <input type="submit" value="開催済み">
    </form>
    @endif
    <!-- 参加者 -->
    @if($user->id!== $event->user_id&&$event->completed_at===null)
    @if($event->isParticipated===false)
    <!-- 参加する -->
    <form action="{{ route('events.participate',['event'=>$event->id]) }}" method="POST">
        @csrf
        <input name="point">
        <input type="submit" value="参加する">
    </form>
    @else
    <!-- 参加キャンセル -->
    <form action="{{ route('events.cancel',['event'=>$event->id]) }}" method="POST">
        @csrf
        <input type="submit" value="参加キャンセル">
    </form>
    @endif
    @endif
</body>

</html>