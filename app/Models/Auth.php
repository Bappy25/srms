<?php

namespace App\Models\People; 

use App\Base\Authenticable;

class Auth extends User{

  /* Declaring all variables */

  protected $auth;

  public function __construct() 
	{
		$this->auth = new Authenticable;
    parent::__construct();
	}

    // Token setter getter
  function setToken($token){
      $this->token = $token;
  }
  function getToken(){
    return $this->token;
  }


  /* All functions */
  
  public function signin(){   
      $auth = $this->auth->signin($this->getUsername(), $this->getPassword());
      if($auth){
        return true;
      }
      else{
        return false;
      }
  }
  
  public function storeLink(){   
    $auth = $this->auth->storeLink($this->getToken(), $this->getId());
    if($auth){
      return true;
    }
    else{
      return false;
    }
  }
  
  public function getLink(){   
    $link = $this->auth->getLink($this->getToken());
    return $link;
  }
  
  public function updateValidity(){  
    $reset = $this->auth->updateValidity($this->getToken());
    return $reset;
  }

  public function signout(){    
      $this->auth->signout();
  }

}