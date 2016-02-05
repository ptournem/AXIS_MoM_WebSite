<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserControllerTest extends TestCase {
    use DatabaseTransactions;
    

    public function testPostAddNoAjax() {
	$user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);

	$this->action('GET', 'UserController@postAdd');
	$this->assertResponseStatus(404);
    }

    public function testPostAddNoAdmin() {
	$user = new User();
	$user->admin = 0;
	$this->withSession(['isConnected' => true, 'user' => $user]);


	$this->action('GET', 'UserController@postAdd');
	$this->assertRedirectedTo('/');
	$this->assertSessionHas('messages');
    }

    public function testPostAddNoParameter() {
	$this->withoutMiddleware();

	$response = $this->action('POST', 'UserController@postAdd', null);
	$this->assertResponseOk();
	$this->isJson();

	$json = json_decode($response->getContent());
	$this->assertObjectHasAttribute("require", $json);
	$this->assertObjectHasAttribute('name', $json->require);
	$this->assertObjectHasAttribute('password', $json->require);
	$this->assertObjectHasAttribute('email', $json->require);
    }

    public function testPostAddMissParameter() {
	$this->withoutMiddleware();
	
	$response1 = $this->action('POST', 'UserController@postAdd', null, array('name' => 'testt', 'email' => 'azert@fr.fr','password'=>'test'));
	$this->assertResponseOk();
	$this->isJson();
	$json1 = json_decode($response1->getContent());
	$this->assertObjectHasAttribute("require", $json1);
	$this->assertObjectHasAttribute('password', $json1->require);
	
	$response2 = $this->action('POST', 'UserController@postAdd', null, array('name' => 'testt', 'email' => 'azert@fr.fr'));
	$this->assertResponseOk();
	$this->isJson();
	$json2 = json_decode($response2->getContent());
	$this->assertObjectHasAttribute("require", $json2);
	$this->assertObjectHasAttribute('password', $json2->require);
	
	$response3 = $this->action('POST', 'UserController@postAdd', null, array('name' => 'testt','password'=>'test25','password_confirmation'=>'test25'));
	$this->assertResponseOk();
	$this->isJson();
	$json3 = json_decode($response3->getContent());
	$this->assertObjectHasAttribute("require", $json3);
	$this->assertObjectHasAttribute('email', $json3->require);
	
	$response4 = $this->action('POST', 'UserController@postAdd', null,array( 'email' => 'azert@fr.fr','password'=>'test25','password_confirmation'=>'test25','admin'=>1));
	$this->assertResponseOk();
	$this->isJson();
	$json4 = json_decode($response4->getContent());
	$this->assertObjectHasAttribute("require", $json4);
	$this->assertObjectHasAttribute('name', $json4->require);
    }

    public function testPostAddOk() {
	$this->withoutMiddleware();
	
	$this->action('POST', 'UserController@postAdd', null, array('name' => 'testt', 'email' => 'azert@fr.fr','password'=>'test25','password_confirmation'=>'test25','admin'=>1));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => true]);
    }

    public function testGetShowNotAdmin(){
	$user = new User();
	$user->admin = 0;
	$this->withSession(['isConnected' => true, 'user' => $user]);


	$this->action('GET', 'UserController@getShow');
	$this->assertRedirectedTo('/');
	$this->assertSessionHas('messages');
    }
    
    public function testGetShowNoParameter() {
	$this->withoutMiddleware();
	
	$this->action('GET', 'UserController@getShow', null);
	$this->assertResponseStatus(500);
    }

    public function testPostDeleteNoAjax() {
	$user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);

	$this->action('GET', 'UserController@postDelete');
	$this->assertResponseStatus(404);
    }

    public function testPostDeleteNoAdmin() {
	$user = new User();
	$user->admin = 0;
	$this->withSession(['isConnected' => true, 'user' => $user]);


	$this->action('GET', 'UserController@postDelete', null, ["name" => "name",]);
	$this->assertRedirectedTo('/');
	$this->assertSessionHas('messages');
    }

    public function testPostDeleteNoParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'UserController@postDelete', null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result'=>false]);
    }
}
