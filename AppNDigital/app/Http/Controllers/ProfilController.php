<?php

namespace App\Http\Controllers;
use App\Commentaires;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use User;
use App\Likes;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $user = Auth::user();

        $getcomms=Commentaires::where('user_id','=',$user->id)->take(6)->get()->all();

        if (isset($getcomms)){
            $histocomm=true;
        }
        else{
            $histocomm=false;
        }


        $checklike=Likes::where('user_id','=',$user->id)->get()->all();

        if (isset($checklike)){
            $histolike=true;


            foreach ($checklike as $key=>$values){
                $t=$values->toArray();

                foreach ($t as $kei=>$val){
//                    var_dump($val);
                }
                $idmovies=$values->id_movie;
                $count=compact('idmovies');
//                $content=file_get_contents('http://www.omdbapi.com/?i=tt3896198&apikey=94c8cc66&s=' . );
//                $data = json_decode($content, true);
//                dd($data);

            }
        }
        else{
            $histolike=false;
        }



        return view('profil', compact('user','histocomm','getcomms','histolike','histocomm','checklike','moviename'));

    }

    public function editPswd(Request $request)
    {
        $user = Auth::user();

        $this->validate($request,
            [
                'old_password' => $user->password,
                'new_password' => 'confirmed|max:8|different:password',
            ]);



        if (Hash::check($request['old_pswd'], $user->password)) {
            $user->fill(
                [
                    'password' => bcrypt($request['new_pswd'])
                ])->save();
            return Redirect()->back()->with('success', 'Votre mot de passe a été modifié avec succès !');
        } else {
            return Redirect()->back()->with('error', 'Votre ancien mot de passe est incorrect !');
        }
    }

    public function gethistoric(){
        $user=Auth::user();

        $getcomms=Commentaires::where('user_id','=',$user->id)->take(6)->get()->all();

        if (isset($getcomms)){
            $histocomm=true;
        }
        else{
            $histocomm=false;
        }

        $checklike=Likes::where('user_id','=',$user->id)->take(6)->get()->all();

//        $flo= DB::table('popmovies')
//            ->join('users','user_id','=','users.id')->get()->all();
//        dd($flo);
        $getcomms=DB::table('users')
            ->join('commentaires','user_id','=','users.id')->get()->all();

        if (isset($checklike)){
            $histolike=true;
        }
        else{
            $histolike=false;
        }



        return view('/profil',compact('getcomms','checklike','user','histocomm','histolike','checklike'));


    }


}
