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

Route::get('/', 'WelcomeController@Index');
Route::get('/home', 'WelcomeController@Index');
Route::get('infos', 'InformationController@Infos');

Route::get('admin', 'Admin\AdminController@Index');
Route::get('admin/view/{id}', 'Admin\AdminController@view');
Route::post('admin/addEntity', 'Admin\AdminController@addEntity');

// TODO
Route::get('admin/users/{users}/editPW', array('as' => 'admin.users.editPW', 'uses' => 'UserController@editPW'));
Route::post('admin/users/{users}', array('as' => 'admin.users.updatePW', 'uses' => 'UserController@updatePW') );

// Authentication routes...
Route::post('auth/connexion', 'Auth\AuthentificationController@postLogin');
Route::post('auth/deconnexion', 'Auth\AuthentificationController@postLogout');

