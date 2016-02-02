<?php

class LogsControllerTest extends TestCase {
    
    public function testDeleteAllNoAjax(){
	$this->action('GET', 'Admin\LogsController@postDeleteLog');
	$this->assertResponseStatus(404);
    }

    public function testDeleteAll() {
	$this->withoutMiddleware();

	$this->action('POST', 'Admin\LogsController@postDeleteLog');
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => true]);
    }

}
