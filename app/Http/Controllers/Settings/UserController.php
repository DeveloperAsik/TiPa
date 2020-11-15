<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author root
 */
class UserController extends Controller {
    //put your code here

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) { 
    }
    
    
    public function index(Request $request){
        $result = [
            [
                'id' => 1,
                'name'=>'restfull api by lumen',
                'create_by' => 'DeveloperAsik'                
            ]
        ];
        $response = json_encode($result);
        return $response;
    }

}
