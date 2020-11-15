<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  

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
class TaskController extends Controller {
    //put your code here

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        
    }

    private $table = 'tbl_tasks AS a';

    public function get_list(Request $request) {
        $offset = $request->input('page') - 1;
        $value = $request->input('value');
        $keyword = $request->input('keyword');
        if ($keyword == 'title') {
            $key = 'a.title';
            $val = '%' . $value . '%';
            $opt = 'like';
        } elseif ($keyword == 'id') {
            $key = 'a.id';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'task_type_id') {
            $key = 'a.task_type_id';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'task_type_name') {
            $key = 'b.name';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'all') {
            $key = '';
            $val = '';
            $opt = '';
        } else {
            return json_encode(array('status' => 201, 'message' => 'Failed retrieving data, param not specified', 'data' => null));
        }
        if ($keyword == 'all') {
            $res = DB::table($this->table)
                            ->select('a.id', 'a.title AS task_title', 'a.description AS task_description')
                            ->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')
                            ->where('a.is_active', 1)->limit($request->input('total'))->offset($offset)->get();
            $total_rows = DB::table($this->table)->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')->where('a.is_active', 1)->count();
        } else {
            $res = DB::table($this->table)
                            ->select('a.id', 'a.title AS task_title', 'a.description AS task_description')
                            ->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')
                            ->where([['a.is_active', 1], [$key, $opt, $val]])->limit($request->input('total'))->offset($offset)->get();
            $total_rows = DB::table($this->table)->where([['a.is_active', 1], [$key, $opt, $val]])->count();
        }
        dd($res);
        if (isset($res) && !empty($res) && $res != null) {
            return json_encode(array('status' => 200, 'message' => 'Successfully retrieving data.', 'meta' => array('page' => $request->input('page'), 'length' => $request->input('total'), 'total_data' => $total_rows), 'data' => $res));
        } else {
            return json_encode(array('status' => 201, 'message' => 'Failed retrieving data', 'data' => null));
        }
    }

}
