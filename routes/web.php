<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', 'Settings\UserController@index');

//get tasks
$router->get('/get-list/tasks/{id}', 'Content\TaskController@get_list');
$router->get('/get-list/tasks', 'Content\TaskController@get_list');

$router->post('/insert/tasks', 'Content\TaskController@insert');
$router->post('/update/tasks', 'Content\TaskController@update');
$router->post('/delete/tasks', 'Content\TaskController@delete');


//get section task
$router->get('/get-list/sections/{id}', 'Content\SectionsController@get_list');
$router->get('/get-list/sections', 'Content\SectionsController@get_list');

$router->post('/insert/sections', 'Content\SectionsController@insert');
$router->post('/update/sections', 'Content\SectionsController@update');
$router->post('/delete/sections', 'Content\SectionsController@delete');