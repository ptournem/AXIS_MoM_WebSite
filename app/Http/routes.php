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

// Controller admin pour la gestion de l'administration
Route::controller('admin','Admin\AdminController',[
    "anySearchEntitySameas" => "admin.searchSameas",
    "getIndex" => "admin.getIndex",
    "postSetProperty" => "admin.setProperty",
    "postDeleteEntity" => "admin.deleteEntity",
    "postDeleteLiteralProperty" => "admin.deleteLiteral",
    "postDeleteEntityProperty" => "admin.deleteEntityProperty",
    "postAddEntity" => "admin.addEntity"    
]);

// TODO
Route::controller('users','UserController',[
    'postAdd'=>'user.add',
    'postDelete'=>'user.delete'
]);
//Route::get('admin/users/{id}', array('as' => 'admin.users.updatePW', 'uses' => 'UserController@show'));

// Authentication routes...
Route::post('auth/connexion', 'Auth\AuthentificationController@postLogin');
Route::post('auth/deconnexion', 'Auth\AuthentificationController@postLogout');

