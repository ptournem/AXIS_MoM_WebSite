<?php

use App\Classes\Dialog\Entity;

class PublicControllerTest extends TestCase {

    public function testRootUrl() {
	$view = view('welcome');
	$response = $this->call('GET', '/');
	$this->assertResponseOk();
	$this->assertEquals($view, $response->original);
    }

    public function testHomeUrl() {
	$view = view('welcome');
	$response = $this->call('GET', '/home');
	$this->assertResponseOk();
	$this->assertEquals($view, $response->original);
    }

    public function testPublicUrl() {
	$view = view('welcome');
	$response = $this->call('GET', '/public');
	$this->assertResponseOk();
	$this->assertEquals($view, $response->original);
    }

    public function testShowWithoutParameter() {
	// appel sans paramètre
	$this->action('GET', 'PublicController@anyEntity');
	$this->assertResponseStatus(500);
    }

    public function testShowEntityWithParameter() {
	$comments = [];
	$properties = [];

	Semantics::shouldReceive('GetEntity')->once()->andReturn(new Entity("URI", "Name", "image", "type"));
	Semantics::shouldReceive('LoadEntityProperties')->once()->andReturn($properties);
	Comments::shouldReceive('LoadComment')->once()->andReturn($comments);

	//appel avec paramètre
	$this->action('GET', 'PublicController@anyEntity', ['uid' => 1]);
	$this->assertResponseOk();
	$this->assertViewHas("comments");
	$this->assertViewHas("infos");
	$this->assertViewHas("entity");
    }

    public function testShowEntityNotFound() {
	Semantics::shouldReceive('GetEntity')->once()->andReturn(null);

	$this->action('GET', 'PublicController@anyEntity', ['uid' => 1]);
	$this->assertRedirectedToAction('PublicController@anyIndex');
    }

    public function testSearchNoAjax() {
	// appel sans paramètre
	$this->action('GET', 'PublicController@anySearchEntity');
	$this->assertResponseStatus(404);
    }

    public function testSearchWithoutParameter() {
	$this->withoutMiddleware();
	// appel sans paramètre
	$response = $this->action('GET', 'PublicController@anySearchEntity');
	$this->assertResponseOk();
	$this->seeJsonEquals([]);
    }

    public function testSearchWithEmptyParameter() {
	$this->withoutMiddleware();
	// appel avec paramètre null
	$response = $this->action('POST', 'PublicController@anySearchEntity', null, array('needle' => ''));
	$this->assertResponseOk();
	$this->seeJsonEquals([]);
    }

    public function testSearchGood() {
	$this->withoutMiddleware();
	// appel avec bon paramètre
	$response = $this->action('POST', 'PublicController@anySearchEntity', null, array('needle' => 'test2'));
	$this->assertResponseOk();
	$this->isJson();
    }

}
