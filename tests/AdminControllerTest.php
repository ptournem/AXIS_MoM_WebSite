<?php

use App\Classes\Dialog\Entity;
use App\User;

class AdminControllerTest extends TestCase {

    public function testRootUrlConnected() { 
        Session::start();
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);

        // Routes GET
	$this->action('GET', 'Admin\AdminController@postSetProperty');
	$this->assertResponseStatus(404);
        $this->action('GET', 'Admin\AdminController@postDeleteEntity');
	$this->assertResponseStatus(404);
        $this->action('GET', 'Admin\AdminController@postDeleteLiteralProperty');
	$this->assertResponseStatus(404);
        $this->action('GET', 'Admin\AdminController@postDeleteEntityProperty');
	$this->assertResponseStatus(404);
        $this->action('GET', 'Admin\AdminController@postAddEntity');
	$this->assertResponseStatus(404);
        $this->action('GET', 'Admin\AdminController@anySearchEntitySameas');
	$this->assertResponseOk();
        $this->action('GET', 'Admin\AdminController@getIndex');
	$this->assertResponseOk();
        $this->action('GET', 'Admin\AdminController@getView', ["uri" => "1"]);
	$this->assertResponseOk();
        
        // Routes POST
        $this->call('POST', 'admin/set-property', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/delete-entity', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/delete-literal-property', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/delete-entity-property', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/add-entity', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/search-entity-sameas', ['_token' => csrf_token()]);
	$this->assertResponseOk();
        $this->call('POST', 'admin/view', ['_token' => csrf_token()]);
	$this->assertResponseStatus(404);
    }
    
    public function testRootUrlNotConnected() { 
        Session::start();
	$this->withSession(['isConnected' => FALSE]);

        // Routes GET
	$this->action('GET', 'Admin\AdminController@postSetProperty');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@postDeleteEntity');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@postDeleteLiteralProperty');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@postDeleteEntityProperty');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@postAddEntity');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@anySearchEntitySameas');
	$this->assertResponseStatus(302);
        $this->action('GET', 'Admin\AdminController@getIndex');
	$this->assertResponseStatus(302);
        
        // Routes POST
        $this->call('POST', 'admin/set-property', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/delete-entity', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/delete-literal-property', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/delete-entity-property', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/add-entity', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/search-entity-sameas', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
        $this->call('POST', 'admin/view', ['_token' => csrf_token()]);
	$this->assertResponseStatus(302);
    }
    
    public function testPostDeleteEntity() { 
        Session::start(); // Start a session for the current test
        
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);
        
        // Sans paramètres
        $params = [
            '_token' => csrf_token()
        ];
        $response = $this->call('POST', 'admin/delete-entity', $params);
        $json = json_decode($response->getContent());
        $this->assertFalse($json->result);
        
        // Avec paramètre
        $params = [
            '_token' => csrf_token(),
            'uri' => "uri"
        ];
        $response = $this->call('POST', 'admin/delete-entity', $params);
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute("success", $json);
    }
    
    public function testPostDeleteEntityProperty() { 
        Session::start(); // Start a session for the current test
        
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);
        
        // Sans paramètres
        $params = [
            '_token' => csrf_token()
        ];
        $response = $this->call('POST', 'admin/delete-entity-property', $params);
        $json = json_decode($response->getContent());
        $this->assertFalse($json->result);
        
        // Avec paramètre
        $params = [
            '_token' => csrf_token(),
            'uri' => "uri",
            'name' => "name",
            'uriB' => "uriB",
        ];
        $response = $this->call('POST', 'admin/delete-entity-property', $params);
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute("success", $json);
    }
    
    public function testPostDeleteLiteralProperty() { 
        Session::start(); // Start a session for the current test
        
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);
        
        // Sans paramètres
        $params = [
            '_token' => csrf_token()
        ];
        $response = $this->call('POST', 'admin/delete-literal-property', $params);
        $json = json_decode($response->getContent());
        $this->assertFalse($json->result);
        
        // Avec paramètre
        $params = [
            '_token' => csrf_token(),
            'uri' => "uri",
            'name' => "name",
        ];
        $response = $this->call('POST', 'admin/delete-literal-property', $params);
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute("success", $json);
    }
    
    public function testPostSetProperty() { 
        Session::start(); // Start a session for the current test
        
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);
        
        // Sans paramètres
        $params = [
            '_token' => csrf_token()
        ];
        $response = $this->call('POST', 'admin/set-property', $params);
        $json = json_decode($response->getContent());
        $this->assertFalse($json->result);
        
        // Avec paramètre
        $params = [
            '_token' => csrf_token(),
            'uri' => "uri",
            'name' => "name",
            'value' => "value",
            'type' => "type",
        ];
        $response = $this->call('POST', 'admin/set-property', $params);
        $json = json_decode($response->getContent());
        $this->assertObjectHasAttribute("success", $json);
    }
    
   /* public function testGetView() {         
        Session::start();
        $user = new User();
	$user->admin = 1;
	$this->withSession(['isConnected' => true, 'user' => $user]);
                
        $this->call('GET', 'admin/view/lala');
	$this->assertResponseOk();
	$this->assertResponseOk();
	$this->assertViewHas("retours");
	$this->assertViewHas("dbpedia");
	$this->assertViewHas("entity");
        $this->assertViewHas("URIencode");
	$this->assertViewHas("dbpediaInfo");
	$this->assertViewHas("comments");
        $this->assertViewHas("nbCommentNotValidated");
    }*/
}
