<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Logs;
use Session;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller {

    protected $userRepository;
    protected $nbrPerPage = 4;

    public function __construct(UserRepository $userRepository) {
	$this->userRepository = $userRepository;
	$this->middleware('isAdmin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getShow($id) {
	$user = $this->userRepository->getById($id);

	return view('admin/users/userShow', compact('user'));
    }

    public function postAdd(Request $request) {
	$this->setAdmin($request);

	// on crée le validator pour la requête
	$validator = Validator::make($request->all(), [
		    'name' => 'required|max:255|unique:users',
		    'email' => 'required|email|max:255|unique:users',
		    'password' => 'required|confirmed|min:6',
		    'admin' => 'required'
	]);

	// Si la requête fail, on revoit un tableau avec les errors
	if ($validator->fails()) {
	    return response()->json(['require' => $validator->errors()]);
	}

	$user = $this->userRepository->store($request->all());


	Logs::add('ADD', $user->name . ' ajouté.', session('user'));

	return response()->json(["result" => true]);
    }

    private function setAdmin($request) {
	if (!$request->has('admin')) {
	    $request->merge(['admin' => 0]);
	}
    }

    public function postDelete(Request $request) {
	if (!$request->has('id')) {
	    return response()->json(['result' => false]);
	}

	$user = $this->userRepository->getById($request->get('id'));
	$user->delete();

	if (session('user')->id == $user->id) {
	    Logs::add('DEL', $user->name . ' a supprimé son compte');
	    Session::forget(['user', 'isConnected']);
	    return redirect('/')->with('message', array('Votre compte a bien été supprimé !'));
	}

	Logs::add('DEL', $user->name . ' supprimé.', session('user'));
	return response()->json(["result" => true]);
    }

}
