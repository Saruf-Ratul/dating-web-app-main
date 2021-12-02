<?php

namespace App\Http\Controllers;

use Session;

class IndexController extends Controller
{
    public function index(){
        //LADING PAGE SHOW IF USER NOT LOGGED IN
        if(empty(Session::has('datingSignInSession'))){
            return view('index');
        }else{
            return redirect('/dating');
        }
        
    }
}
