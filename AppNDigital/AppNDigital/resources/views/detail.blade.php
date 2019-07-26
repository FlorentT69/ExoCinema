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
<div class="container ">
    <div class="row">
        <div class="col-sm-6">
            <div class="card " style="width: 25rem; padding: 25px;" id={{$data['imdbID']}}>
                <h3>{{$data["Title"]}}</h3>

                <img src={{$data["Poster"]}} class="card-img-top" alt="...">
                <div class="card-body">

                    <ul>
                        <li>Date de sortie: {{$data['Year']}}</li>
                        <li>Duree: {{$data['Runtime']}}</li>
                        <li>Genre: {{$data['Genre']}}</li>
                        <li>Description: {{$data['Plot']}}</li>
                        <li>Vues: {{$movie['nb_views']}}</li>
                        @if(!isset($nblikes))
                            <li><h5 class="bolder">{{$nonelike}} likes</h5></li>
                        @else
                            <li><h5 class="bolder">{{$nblikes}} likes</h5></li>
                        @endif
                    </ul>
                    @auth

                        @if($checkclick==true || $check==true)

                            <button type="submit" class="btn btn-info disabled"    >Like</button>
                        @endif
                        <form method="post" action="/detail/{{$data['imdbID']}}/like">
                            @csrf


                            @if($checkclick==false || $check==false)
                                <button type="submit" class="btn btn-info "   >Like</button>
                            @endif
                        </form>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Post new comment</button>

                        <!-- Modal new comm -->
                        <form method="post" action="/detail/{{$data['imdbID']}}/addcomm">
                            @csrf
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="content">Votre commentaire :</label>
                                                <input type="text" class="form-control" name="comment">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Poster</button>
                                        </div>
                                        <hr/>
                                    </div>
                                </div>

                            </div>
                        </form>


                    @endauth
                    @guest
                        login expected to like !
                    @endguest

                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center"><strong><u>Commentaires</u></strong></h4>

                    @if($nullcomm===true || $getcomm==true )
                        <p class="card-text"><small class="text-muted">Aucun commentaire a ce jour</small></p>
                    @endif
                        @if($nullcomm===false )

                        @foreach($getcomm as $key =>$values)
                            <div>
                            <h5>{{$values->name}}</h5>
                                <p class="card-text"     >{{$values->content}}</p>
                            @if($user_id==$values->user_id)

                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal">modifier mon commentaire</button><br><br>
                                <form method="post" action='/detail/{{$data['imdbID']}}/delete/{{$values->id}}'>
                                    @csrf
                                    <button type="submit" class="btn btn-danger"  value={{$values->id}}>Supprimer le commentaire</button><br><br>

                                </form>
                                <!-- Modal edit comm-->
                                <form method="post" action="/detail/{{$data['imdbID']}}/editcomm">
                                    @csrf
                                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="content">Votre commentaire :</label>
                                                        <input type="text" class="form-control" name="comment" placeholder={{$values->content}}>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">confirmer modifications</button>
                                                </div>
                                                <hr/>
                                            </div>
                                        </div>

                                    </div>
                                </form>

                            @endif
                            <h6 class="card-subtitle text-muted">{{$values->created_at}}</h6><hr>

                        @endforeach
                            </div>
                    @endif
                    <hr/>

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
@endsection