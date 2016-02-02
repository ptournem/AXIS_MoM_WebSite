<?php

use App\Classes\Dialog\Entity;
use App\Classes\Dialog\Comment;

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

    public function testShowEntityNoPropertyFound() {
	$comments = [];
	$properties = null;

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

    public function testSearchNoAjax() {
	// appel sans paramètre
	$this->action('GET', 'PublicController@anySearchEntity');
	$this->assertResponseStatus(404);
    }

    public function testSearchWithoutParameter() {
	$this->withoutMiddleware();
	// appel sans paramètre
	$this->action('GET', 'PublicController@anySearchEntity');
	$this->assertResponseOk();
	$this->seeJsonEquals([]);
    }

    public function testSearchWithEmptyParameter() {
	$this->withoutMiddleware();
	// appel avec paramètre null
	$this->action('POST', 'PublicController@anySearchEntity', null, array('needle' => ''));
	$this->assertResponseOk();
	$this->seeJsonEquals([]);
    }

    public function testSearchGood() {
	$this->withoutMiddleware();
	// appel avec bon paramètre
	$this->action('POST', 'PublicController@anySearchEntity', null, array('needle' => 'test2'));
	$this->assertResponseOk();
	$this->isJson();
    }

    public function testPostCommentNoAjax() {
	$this->action('GET', 'PublicController@postComment');
	$this->assertResponseStatus(404);
    }

    public function testPostCommentMissCommentParameter() {
	$this->withoutMiddleware();

	$response1 = $this->action('POST', 'PublicController@postComment', null, array('Nom' => 'test', 'Mail' => 'azert@fr.fr'));
	$this->assertResponseOk();
	$this->isJson();
	$json1 = json_decode($response1->getContent());
	$this->assertObjectHasAttribute("require", $json1);
	$this->assertObjectHasAttribute('Commentaire', $json1->require);

	$response2 = $this->action('POST', 'PublicController@postComment', null, array('Nom' => 'test', 'Commentaire' => ''));
	$this->assertResponseOk();
	$this->isJson();
	$json2 = json_decode($response2->getContent());
	$this->assertObjectHasAttribute("require", $json2);
	$this->assertObjectHasAttribute('Mail', $json2->require);

	$response3 = $this->action('POST', 'PublicController@postComment', null, array('Mail' => 'azert@fr.fr', 'Commentaire' => 'comment'));
	$this->assertResponseOk();
	$this->isJson();
	$json3 = json_decode($response3->getContent());
	$this->assertObjectHasAttribute("require", $json3);
	$this->assertObjectHasAttribute('Nom', $json3->require);
    }

    public function testPostCommentMissEntityParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'PublicController@postComment', null, array('Nom' => 'test', 'Mail' => 'azert@fr.fr', 'Commentaire' => 'comment'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => false]);
    }

    public function testPostCommentNoParameter() {
	$this->withoutMiddleware();
	$response = $this->action('POST', 'PublicController@postComment', null);
	$this->assertResponseOk();
	$this->isJson();

	$json = json_decode($response->getContent());
	$this->assertObjectHasAttribute("require", $json);
	$this->assertObjectHasAttribute('Nom', $json->require);
	$this->assertObjectHasAttribute('Commentaire', $json->require);
	$this->assertObjectHasAttribute('Mail', $json->require);
    }

    public function testPostCommentGood() {
	$this->withoutMiddleware();

	Comments::shouldReceive('AddComment')->once()->andReturn(new Comment());

	$this->action('POST', 'PublicController@postComment', null, array('Nom' => 'test', 'Mail' => 'mail@gmail.com', 'Commentaire' => 'test', 'entity' => 'azert'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => true]);
    }

}
