<?php

use App\Classes\Dialog\Comment;

class CommentControllerTest extends TestCase {

    public function testGrantCommentNoAjax() {
	$this->action('GET', 'CommentController@postGrantComment');
	$this->assertResponseStatus(404);
    }

    public function testDenyCommentNoAjax() {
	$this->action('GET', 'CommentController@postDenyComment');
	$this->assertResponseStatus(404);
    }

    public function testRemoveCommentNoAjax() {
	$this->action('GET', 'CommentController@postRemoveComment');
	$this->assertResponseStatus(404);
    }

    public function testRemoveCommentNoParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'CommentController@postRemoveComment', null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => false));
    }
    
    public function testRemoveCommentMissingParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'CommentController@postRemoveComment', null,array('id'=>'http:||test.fr|2'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => false));
	
	$this->action('POST', 'CommentController@postRemoveComment', null,array('entity'=>'http:||test.fr|3'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => false));
    }

    public function testDenyCommentNoParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'CommentController@postDenyComment', null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => false));
    }

    public function testGrantCommentNoParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'CommentController@postDenyComment', null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => false));
    }

    public function testGrantComment() {
	$this->withoutMiddleware();

	Comments::shouldReceive('GrantComment')->once()->andReturn(true);

	$this->action('POST', 'CommentController@postGrantComment', null, array('id' => 'http:||axis-mom.fr|'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => true));
    }

    public function testDenyComment() {
	$this->withoutMiddleware();

	Comments::shouldReceive('DenyComment')->once()->andReturn(true);

	$this->action('POST', 'CommentController@postDenyComment', null, array('id' => 'http:||axis-mom.fr|'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => true));
    }

    public function testRemoveComment() {
	$this->withoutMiddleware();

	Comments::shouldReceive('RemoveComment')->once()->andReturn(true);

	$this->action('POST', 'CommentController@postRemoveComment', null, array('id' => 'http:||axis-mom.fr|1','entity'=>'http:||axis-mom.fr|2'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result' => true));
    }

    public function testPostCommentNoAjax() {
	$this->action('GET', 'CommentController@postComment');
	$this->assertResponseStatus(404);
    }

    public function testPostCommentMissCommentParameter() {
	$this->withoutMiddleware();

	$response1 = $this->action('POST', 'CommentController@postComment', null, array('Nom' => 'test', 'Mail' => 'azert@fr.fr'));
	$this->assertResponseOk();
	$this->isJson();
	$json1 = json_decode($response1->getContent());
	$this->assertObjectHasAttribute("require", $json1);
	$this->assertObjectHasAttribute('Commentaire', $json1->require);

	$response2 = $this->action('POST', 'CommentController@postComment', null, array('Nom' => 'test', 'Commentaire' => ''));
	$this->assertResponseOk();
	$this->isJson();
	$json2 = json_decode($response2->getContent());
	$this->assertObjectHasAttribute("require", $json2);
	$this->assertObjectHasAttribute('Mail', $json2->require);

	$response3 = $this->action('POST', 'CommentController@postComment', null, array('Mail' => 'azert@fr.fr', 'Commentaire' => 'comment'));
	$this->assertResponseOk();
	$this->isJson();
	$json3 = json_decode($response3->getContent());
	$this->assertObjectHasAttribute("require", $json3);
	$this->assertObjectHasAttribute('Nom', $json3->require);
    }

    public function testPostCommentMissEntityParameter() {
	$this->withoutMiddleware();

	$this->action('POST', 'CommentController@postComment', null, array('Nom' => 'test', 'Mail' => 'azert@fr.fr', 'Commentaire' => 'comment'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => false]);
    }

    public function testPostCommentNoParameter() {
	$this->withoutMiddleware();
	$response = $this->action('POST', 'CommentController@postComment', null);
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

	$this->action('POST', 'CommentController@postComment', null, array('Nom' => 'test', 'Mail' => 'mail@gmail.com', 'Commentaire' => 'test', 'entity' => 'azert'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => true]);
    }

}
