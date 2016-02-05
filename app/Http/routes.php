<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', 'PublicController@anyIndex');
Route::get('/home', 'PublicController@anyIndex');

// Controller public pour les interraction publiques
Route::controller('public', 'PublicController', [
    "anySearchEntity" => "public.search",
    "anySearchEntitySameas" => "public.searchSameas",
    "anyEntity" => "public.show",
]);

// Controller log pour la suppresion des logs
Route::controller('logs', 'Admin\LogsController', [
    "postDeleteLog" => "log.deleteAll",
]);

// Controller comment pour la gestion des commentaires
Route::controller('comments', 'CommentController', [
    "postGrantComment" => "comment.grant",
    "postDenyComment" => "comment.deny",
    "postRemoveComment" => "comment.remove",
    "postComment" => "comment.add",
]);

Route::controller('admin','Admin\AdminController',["anySearchEntitySameas" => "admin.searchSameas"]);

Route::post('admin/delete-literal-property', array('as' => 'admin.deleteLiteral', 'uses' => 'Admin\AdminController@postDeleteLiteralProperty'));
Route::get('admin/view/{uri}/{name}/{value}/{type}/', 'Admin\AdminController@setEntityProperty');
Route::post('admin/view/{uri}/{name}/{uriB}', array('as' => 'admin.deleteEntity', 'uses' => 'Admin\AdminController@postDeleteEntityProperty'));
Route::get('admin/addEntity/{type}/{name}/{description}/{image}', 'Admin\AdminController@addEntity');

// TODO
Route::controller('users','UserController',[
    'postAdd'=>'user.add',
    'postDelete'=>'user.delete'
]);
//Route::get('admin/users/{id}', array('as' => 'admin.users.updatePW', 'uses' => 'UserController@show'));

// Authentication routes...
Route::post('auth/connexion', 'Auth\AuthentificationController@postLogin');
Route::post('auth/deconnexion', 'Auth\AuthentificationController@postLogout');

