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
        } elseif ($keyword == 'task_type_id') {
            $key = 'a.task_type_id';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'task_type_name') {
            $key = 'b.name';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'task_section_id') {
            $key = 'a.task_section_id';
            $val = $value;
            $opt = '=';
        } elseif ($keyword == 'task_section_name') {
            $key = 'c.name';
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
                            ->select('a.id', 'a.title AS task_title', 'a.description AS task_description', 'a.created_by AS create_by', 'a.created_at AS task_create_date', 'b.id AS task_type_id', 'b.title AS task_type_name', 'c.id AS task_section_id', 'c.title AS task_section_name')
                            ->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')
                            ->leftJoin('tbl_task_sections AS c', 'c.id', '=', 'a.task_section_id')
                            ->where('a.is_active', 1)->limit($total)->offset($offset)->get();
            $total_rows = DB::table($this->table)->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')->where('a.is_active', 1)->count();
        } else {
            $res = DB::table($this->table)
                            ->select('a.id', 'a.title AS task_title', 'a.description AS task_description', 'a.created_by AS create_by', 'a.created_at AS task_create_date', 'b.id AS task_type_id', 'b.title AS task_type_name', 'c.id AS task_section_id', 'c.title AS task_section_name')
                            ->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')
                            ->leftJoin('tbl_task_sections AS c', 'c.id', '=', 'a.task_section_id')
                            ->where([['a.is_active', 1], [$key, $opt, $val]])->limit($total)->offset($offset)->get();
            $total_rows = DB::table($this->table)->leftJoin('tbl_task_types AS b', 'b.id', '=', 'a.task_type_id')->where([['a.is_active', 1], [$key, $opt, $val]])->count();
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
                        "task_section_id" => $post['task_section_id'],
                        "task_type_id" => $post['task_type_id'],
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
                    ->update([
                "title" => $post['title'],
                "description" => $post['description'],
                "task_section_id" => $post['task_section_id'],
                "task_type_id" => $post['task_type_id']
            ]);
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
