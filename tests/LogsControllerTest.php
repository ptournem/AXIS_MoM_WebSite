<?php

class LogsControllerTest extends TestCase {

    public function testDeleteAll() {
	$this->withoutMiddleware();

	$this->action('POST', 'Admin\LogsController@postDeleteLog');
	$this->assertResponseOk();
	$this->isJson();
	$this->seeJsonEquals(['result' => true]);
    }

}
