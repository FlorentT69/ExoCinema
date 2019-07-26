<?php

namespace App\Http\Controllers;

use App\Likes;
use App\Popmovies;
use App\Commentaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Table;

class PopmovieController extends Controller
{



    public function index(Request $request,$id){

        $movie=Popmovies::where('id_movie','=',$id)->first();
        $nonelike=0;
        $getcomm=Commentaires::where('id_movie','=',$id)->get();

        if (!isset($getcomm)){

            $nullcomm=true;
        }
        else{

            $nullcomm=false;
        }
        if (!isset($movie)){

            $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
            $data = json_decode($mov, true);
            DB::table('popmovies')->insert(
                ['id_movie'=>$id,'nb_views'=>1,'nb_likes'=>0]
            );
            return view('detail',compact('data','nonelike','content','nullcomm'));

        }
        else{

            $movie->nb_views++;
            $movie->save();
            $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
            $data = json_decode($mov, true);

            return view('detail',compact('data','nonelike','checkclick','content','nullcomm'));

        }



    }

    public function likemovie($id){
        $user=auth()->user();
        $user_id=$user['id'];

        $getcomm=Commentaires::where('id_movie','=',$id)->get();

        if (!isset($getcomm)){

            $nullcomm=true;
        }
        else{

            $nullcomm=false;
        }
        $checklike=Likes::where('user_id','=',$user_id)->where('id_movie','=',$id)->get()->first();
        $movie=Popmovies::where('id_movie','=',$id)->get()->first();
        $nonelike=0;

        if(!isset($checklike)){
            $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
            $data = json_decode($mov, true);
            DB::table('likes')->insert(
                ['user_id'=>$user_id,'id_movie'=>$id]
            );

            $check=true;
            $checkclick=true;
        }

        $checkclick=false;
        $check=false;

        $movie->nb_views++;
        $movie->nb_likes++;
        $nblikes=$movie->nb_likes;

        $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
        $data = json_decode($mov, true);

        return view('detail', compact('data','nblikes','nonelike','check','checkclick','movie','content','nullcomm','getcomm','user_id'));


    }

}
