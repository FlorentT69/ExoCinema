@extends('layouts.app')
@section('content')
        <!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

<div class="container">
    <div class="card-columns">
        @foreach($res as  $key => $values)
        <div class="card card-pulse">
            <a href="detail/{{$values['imdbID']}}"><img class="card-img-top" style="width: 100%; height: 500px;" src={{$values["Poster"]}} alt="Card"></a>
            <div class="card-body">
                <h4 class="card-title text-center"><strong>{{$values["Title"]}}</strong></h4>
            </div>
        </div>
        @endforeach
    </div>
</div>

</body>
</html>
@endsection