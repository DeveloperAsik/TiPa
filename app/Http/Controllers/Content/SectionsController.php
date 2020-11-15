<?php

namespace App\Http\Controllers\Content;

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
class SectionsController extends Controller {
    //put your code here

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request) {
        
    }

    private $table = 'tbl_task_sections AS a';

    public function get_list(Request $request, $id = null) {
        $offset = $request->input('page') - 1;
        $value = $request->input('value');
        $keyword = $request->input('keyword');
        $total = $request->input('total');
        if ($id != null) {
            $offset = 0;
            $keyword = 'id';
            $value = $id;
            $total = 1;
        }
        if ($keyword == 'title') {
            $key = 'a.title';
            $val = '%' . $value . '%';
            $opt = 'like';
        } elseif ($keyword == 'id') {
            $key = 'a.id';
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
            $res = DB::table($this->table)->where('a.is_active', 1)->limit($total)->offset($offset)->get();
            $total_rows = DB::table($this->table)->where('a.is_active', 1)->count();
        } else {
            $res = DB::table($this->table)->where([['a.is_active', 1], [$key, $opt, $val]])->limit($total)->offset($offset)->get();
            $total_rows = DB::table($this->table)->where([['a.is_active', 1], [$key, $opt, $val]])->count();
        }
        if (isset($res) && !empty($res) && $res != null) {
            return json_encode(array('status' => 200, 'message' => 'Successfully retrieving data.', 'meta' => array('page' => $request->input('page'), 'length' => $request->input('total'), 'total_data' => $total_rows), 'data' => $res));
        } else {
            return json_encode(array('status' => 201, 'message' => 'Failed retrieving data', 'data' => null));
        }
    }

    public function insert(Request $request) {
        $post = Request::post();
        if (isset($post) && !empty($post)) {
            $res = DB::table($this->table)->insertGetId(
                    [
                        "title" => $post['title'],
                        "description" => $post['description'],
                        "is_active" => 1,
                        "created_by" => $this->user_token->user_id,
                        "created_date" => Tools::getDateNow()
                    ]
            );
            if ($res) {
                return json_encode(array('status' => 200, 'message' => 'Successfully insert data into db', 'data' => array('id' => $res)));
            } else {
                return json_encode(array('status' => 201, 'message' => 'Failed insert data into db', 'data' => null));
            }
        }
    }

    public function update(Request $request) {
        $post = Request::post();
        if (isset($post) && !empty($post) && $post['id']) {
            $res = DB::table($this->table)
                    ->where('id', $post['id'])
                    ->update(['title' => $post['title'], 'description' => $post['description']]);
            if ($res) {
                return json_encode(array('status' => 200, 'message' => 'Successfully update data into db', 'data' => array('id' => $post['id'])));
            } else {
                return json_encode(array('status' => 201, 'message' => 'Failed update data into db', 'data' => null));
            }
        }
    }

    public function delete() {
        $post = Request::post();
        if (isset($post) && !empty($post) && $post['id']) {
            DB::table($this->table)->where('id', '=', $post['id'])->delete();
        }
    }

}
