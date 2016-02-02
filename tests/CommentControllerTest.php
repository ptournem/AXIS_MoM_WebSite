<?php

class CommentControllerTest extends TestCase {
    public function testGrantCommentNoAjax(){
	$this->action('GET', 'Admin\CommentController@postGrantComment');
	$this->assertResponseStatus(404);
    }
    public function testDenyCommentNoAjax(){
	$this->action('GET', 'Admin\CommentController@postDenyComment');
	$this->assertResponseStatus(404);
    }
    public function testRemoveCommentNoAjax(){
	$this->action('GET', 'Admin\CommentController@postRemoveComment');
	$this->assertResponseStatus(404);
    }
    
    public function testRemoveCommentNoParameter(){
	$this->withoutMiddleware();
	
	$this->action('POST', 'Admin\CommentController@postRemoveComment',null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>false));
    }
    public function testDenyCommentNoParameter(){
	$this->withoutMiddleware();
	
	$this->action('POST', 'Admin\CommentController@postDenyComment',null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>false));
    }
    public function testGrantCommentNoParameter(){
	$this->withoutMiddleware();
	
	$this->action('POST', 'Admin\CommentController@postDenyComment',null);
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>false));
    }
    
    public function testGrantComment(){
	$this->withoutMiddleware();
	
	Comments::shouldReceive('GrantComment')->once()->andReturn(true);
	
	$this->action('POST', 'Admin\CommentController@postGrantComment',null,array('id'=>'http:||axis-mom.fr|'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>true));
    }
    
    public function testDenyComment(){
	$this->withoutMiddleware();
	
	Comments::shouldReceive('DenyComment')->once()->andReturn(true);
	
	$this->action('POST', 'Admin\CommentController@postDenyComment',null,array('id'=>'http:||axis-mom.fr|'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>true));
    }
    
    public function testRemoveComment(){
	$this->withoutMiddleware();
	
	Comments::shouldReceive('RemoveComment')->once()->andReturn(true);
	
	$this->action('POST', 'Admin\CommentController@postRemoveComment',null,array('id'=>'http:||axis-mom.fr|'));
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(array('result'=>true));
    }
}
