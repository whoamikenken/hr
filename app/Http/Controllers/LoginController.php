<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function index(Request $request){
        // dd("wew");
        if(Auth::check()){
            return redirect()->route('home');
        }else{
            return view('auth/login');
        }
        // dd(Auth::check());
        // $menus = DB::table('menus')->where('root', '=', '0')->get();
        // foreach ($menus as $key => $value) {
        //     $data['menus'][$value->title] = json_decode(DB::table('menus')->where("root", "=", $value->menu_id)->orderBy("order", "asc")->get());
        // }

        // $data['navSelected'] = 1;
        // $data['menuSelected'] = 5;
        // return view('home', $data);

    }
}
