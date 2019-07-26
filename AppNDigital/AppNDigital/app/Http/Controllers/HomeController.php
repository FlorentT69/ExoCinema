<?php

namespace App\Http\Controllers;

use App\User;
use App\Likes;
use App\Commentaires;
use App\Popmovies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');

    }

    public function searchbar(Request $request){
        $word = $request->input('search');
        $content=file_get_contents('http://www.omdbapi.com/?i=tt3896198&apikey=94c8cc66&s=' . $word);
        $data = json_decode($content, true);

        if ($data['Response']==false ){
            dd('ya rien ');

        }
        else
        {
            $res = $data['Search'];
        }

        return view("search", compact("res"));
    }

    public function detailmovie($id){

        $user=auth()->user();
        $user_id=$user['id'];

        $checklike=Likes::where('user_id','=',$user_id)->where('id_movie','=',$id)->get()->first();
        $movie=Popmovies::where('id_movie','=',$id)->first();

        $getcomm=Commentaires::where('id_movie','=',$id)->get()->all();


        $getcomms=DB::table('users')
            ->join('commentaires','user_id','=','users.id')->get()->all();

        if (empty($getcomm)){

            $nullcomm=true;
        }
        else{

            $nullcomm=false;


        }
        $nonelike=0;

        if (isset($checklike)){
            $check=true;
            $checkclick=true;
        }
        else{
            $check=false;
            $checkclick=false;
        }


        if (!isset($movie)){
            $checkclick=false;
            $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
            $data = json_decode($mov, true);
            $nblikes=$movie['nb_likes'];

            DB::table('popmovies')->insert(
                ['id_movie'=>$id,'nb_views'=>1,'nb_likes'=>0]
            );
            return view('detail',compact('data','nonelike','checkclick','nblikes','check','movie','getcomm','nullcomm','content','getcomms','user_id'));
        }
        else{
            $movie->nb_views++;
            $movie->save();
            $nblikes=$movie->nb_likes;

        }


        $mov=file_get_contents('http://www.omdbapi.com/?apikey=94c8cc66&i='.$id );
        $data = json_decode($mov, true);

        return view('detail',compact('data','nblikes','nonelike','checkclick','check','movie','getcomm','nullcomm','content','getcomms','user_id'));
    }


}
