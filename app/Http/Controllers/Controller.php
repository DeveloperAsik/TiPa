<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

class Controller extends BaseController {

    //


    public function __construct(Request $request) {
        dd($request);die();
        $this->auth_user($request);
    }
    
    public function auth_user(){
        
    }

}
