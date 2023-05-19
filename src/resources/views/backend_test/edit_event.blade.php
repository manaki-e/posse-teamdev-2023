<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger">
        {{ $error }}
    </div>
    @endforeach
    <form action="{{ route('events.update',['event'=>$event->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <input name="title" value="{{$event->title}}">
        <textarea cols="50" rows="4" name="description">{{ $event->description }}</textarea>
        <input type="datetime-local" name="date" value="{{$event->date}}">
        <input name="location" value="{{$event->location}}">
        @foreach($event_tags as $event_tag)
        @if($event_tag->is_chosen)
        <label>
            <input type="checkbox" name="tags[]" value="{{$event_tag->id}}" checked>
            {{$event_tag->name}}
        </label>
        @else
        <label>
            <input type="checkbox" name="tags[]" value="{{$event_tag->id}}">
            {{$event_tag->name}}
        </label>
        @endif
        @endforeach
        <input type="submit" value="編集する">
    </form>
</body>

</html>