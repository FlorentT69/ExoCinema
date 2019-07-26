@extends('layouts.app')
@section('content')
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container">
    @if(session('error'))
        <div class="alert alert-danger  alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <i class="fas fa-times" id="icon-mr"></i> <strong>{{session('error')}}</strong>
        </div>
        <hr>
    @endif
    @if(session('success'))
        <div class="alert alert-success  alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <i class="fas fa-check" id="icon-mr"></i><strong>{{session('success')}}</strong>
        </div>
        <hr>
    @endif
    <div id="card-edit" class="card w-100 mb-4">
        <div class="card-header">
            <i class="fa fa-user"></i> Vos informations
        </div>
        <div class="card-body">
            <table class="table table-striped screen-table">
                <tbody>
                <tr>
                    <td><strong>Prénom</strong></td>
                    <td>{{$user->name}}</td>
                </tr>
                <tr>
                    <td><strong>Adresse mail</strong></td>
                    <td>{{$user->email}}</td>
                </tr>
                <tr>
                    <td><strong>Creation du compte</strong></td>
                    <td>{{\Carbon\Carbon::parse($user->created_at)->format('d/m/Y')}}</td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="justify-content-center">
            <a class="btn btn-primary" data-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">Mes derniers Likes</a>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapseExample3" aria-expanded="false" aria-controls="multiCollapseExample2">Mes dernieres Commentaires</button>
        </div>
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample1">
                    <div class="card card-body">
                        @if($histolike==true)
                            @foreach($checklike as $key=>$values)
                                <ul>
                                    <li>{{$values->id_movie}}</li>
                                </ul>
                            @endforeach
                        @elseif($histolike==false)
                            <h4> aucun like</h4>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapseExample3">
                    <div class="card card-body">
                        @if($histocomm==true)
                            @foreach($getcomms as $key=>$values)
                                <ul>
                                    <li>{{$values->content}}</li>
                                </ul>
                            @endforeach
                        @elseif($histocomm==false)
                            <h4> aucun commentaires</h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="card-edit" class="card w-100 mb-4">
        <div class="card-header">
            <i class="fa fa-edit"></i> Modifier votre mot de passe
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('editPswd') }}">
                @csrf
                <div class="form-group row">
                    <label for="old_pswd" class="col-md-4 col-form-label text-md-right">{{ __("Ancien mot de passe") }}</label>
                    <div class="col-md-6">
                        <input id="old_pswd" type="password" class="form-control" name="old_pswd" required autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="new_pswd" class="col-md-4 col-form-label text-md-right">{{ __("Nouveau mot de passe") }}</label>
                    <div class="col-md-6">
                        <input id="new_pswd" type="password" class="form-control" name="new_pswd" required autofocus>
                    </div>
                    <div class="col-md-6 m-auto mt-5">
                        <button type="submit" class="btn btn-primary edit-btn"><i class="fas fa-edit"></i> Modifier</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
@endsection