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
]);

Route::get('admin', 'Admin\AdminController@Index');
Route::get('admin/view/{id}', 'Admin\AdminController@view');
Route::post('admin/addEntity', 'Admin\AdminController@addEntity');

// TODO
Route::get('admin/users/{users}/editPW', array('as' => 'admin.users.editPW', 'uses' => 'UserController@editPW'));
Route::post('admin/users/{users}', array('as' => 'admin.users.updatePW', 'uses' => 'UserController@updatePW'));

// Authentication routes...
Route::post('auth/connexion', 'Auth\AuthentificationController@postLogin');
Route::post('auth/deconnexion', 'Auth\AuthentificationController@postLogout');

