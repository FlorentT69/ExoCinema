<?php

namespace App\Http\Controllers;

use App\Likes;
use App\Popmovies;
use App\Commentaires;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function addcom(Request $request ,$id){

        $user=auth()->user();
        $user_id=$user['id'];

        $checklike=Likes::where('user_id','=',$user_id)->where('id_movie','=',$id)->get()->first();
        $movie=Popmovies::where('id_movie','=',$id)->first();
        $nonelike=0;

        if (isset($checklike)){
            $check=true;
            $checkclick=true;
        }
        else{
            $check=false;
            $checkclick=false;
        }

        $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
        $data = json_decode($mov, true);

        DB::table('commentaires')->insert(
            ['user_id'=>$user_id,'id_movie'=>$id,'content'=>$request->input('comment')]
        );
        $getcomm=Commentaires::where('id_movie','=',$id)->get();
        $getcomms=DB::table('commentaires')
            ->join('users','user_id','=','users.id')->get();

        if (!isset($getcomm)){

            $nullcomm=true;
        }
        else{

            $nullcomm=false;
        }
        return view('detail', compact('data','movie','nonelike','checkclick','check','content','nullcomm','getcomm','getcomms','user_id'));
    }




    public  function getcomm($id){

        $user=auth()->user();
        $user_id=$user['id'];

        $getcomm=Commentaires::where('id_movie','=',$id)->get();
        $getcomms=DB::table('users')
            ->join('commentaires','user_id','=','users.id')->get()->all();

        if (!isset($getcomm)){

            $nullcomm=true;
        }
        else{
            $nullcomm=false;
        }


        $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
        $data = json_decode($mov, true);

        $checklike=Likes::where('user_id','=',$user_id)->where('id_movie','=',$id)->get()->first();
        $movie=Popmovies::where('id_movie','=',$id)->first();
        $nonelike=0;

        if (isset($checklike)){
            $check=true;
            $checkclick=true;
        }
        else{
            $check=false;
            $checkclick=false;
        }

        return view('detail',compact('data','content','movie','nonelike','checkclick','check','nullcomm','getcomm','getcomms','user_id'));

    }

    public function editcomm(){

    }


    public function deletecomm(Request $request,$id,$idmovie){
        $user=auth()->user();

        $user_id=$user['id'];

        $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
        $data = json_decode($mov, true);
        $nonelike=0;
        $checklike=Likes::where('user_id','=',$user_id)->where('id_movie','=',$id)->get()->first();
        $movie=Popmovies::where('id_movie','=',$id)->first();
        $getcomm=Commentaires::where('id_movie','=',$id)->get();

        if (isset($checklike)){
            $check=true;
            $checkclick=true;
        }
        else{
            $check=false;
            $checkclick=false;
        }

        if (!isset($getcomm)){

            $nullcomm=true;

        }
        else{

            $nullcomm=false;
        }

        $getcomms=DB::table('users')
            ->join('commentaires','user_id','=','users.id')->get();


        DB::table('commentaires')->where('id','=',$idmovie)->delete();

        return view('detail',compact('data','content','movie','nonelike','checkclick','check','nullcomm','getcomm','getcomms','user_id'));

    }
}
