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

Route::get('admin', 'Admin\AdminController@Index');
Route::post('admin', 'Admin\AdminController@Index');
Route::get('admin/view/{uri}', 'Admin\AdminController@view');
Route::get('admin/printQrCode/{uri}', 'Admin\AdminController@printQrCode');
Route::get('admin/view/{uri}/{name}/{value}/{type}/', 'Admin\AdminController@setEntityProperty');
Route::get('admin/view/{uri}/{name}/{uriB?}', 'Admin\AdminController@deleteEntityProperty');
Route::get('admin/delete/LOD/{EntityID}/{LODID}', 'Admin\AdminController@deleteLOD');
Route::get('admin/update/LOD/{EntityID}/{LODID}/{value}', 'Admin\AdminController@updateLOD');
Route::get('admin/addEntity/{type}/{name}/{description}/{image}', 'Admin\AdminController@addEntity');

// TODO
Route::get('admin/users/{users}/editPW', array('as' => 'admin.users.editPW', 'uses' => 'UserController@editPW'));
Route::get('admin/users/{id}', array('as' => 'admin.users.updatePW', 'uses' => 'UserController@show'));

// Authentication routes...
Route::post('auth/connexion', 'Auth\AuthentificationController@postLogin');
Route::post('auth/deconnexion', 'Auth\AuthentificationController@postLogout');

