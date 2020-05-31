<?php

namespace App\Clients\Clover;

class Client {

  private $authToken;

  private $endpoint;
  private $request_query = false;
  private $request_body = false;




  function __construct ($authToken = null) 
  {
    $this->authToken = $authToken;
  }

  private function setRequestPayload ($payload) 
  {
    $this->request_query    =   [];
    $this->request_body     =   [];

    if($payload && is_array($payload)) {
      if(array_key_exists("query", $payload))
        $this->request_query=   $payload["query"];
      if(array_key_exists("data", $payload))
        $this->request_body =   $payload["data"];
    }
  }

  private function getEndpoint () 
  {
      return $this->endpoint;
  }

  private function setEndpoint ($endpoint)
  {
    $this->endpoint       =       strpos($endpoint, "https://") === 0
                                      ? $endpoint
                                      : (env("CLOVER_URL") ? env("CLOVER_URL").str_replace(env("CLOVER_URL"), "", $endpoint) : $endpoint);
  }

  private function getRequestQuery () 
  {
      return                      $this->request_query && is_array($this->request_query) ? $this->request_query : [];
  }

  private function getRequestBody () 
  {
      return                      $this->request_body && (is_array($this->request_body) || is_object($this->request_body)) ? $this->request_body : [];
  }

  private function getResourceConfig () 
  {
      return (object)[
          "auth_token"    =>      $this->authToken, 
          "endpoint"      =>      $this->getEndpoint(),
          "query"         =>      $this->getRequestQuery(),
          "body"          =>      $this->getRequestBody(),
      ];
  }

  public function orders ($params = []) {
    $this->setEndpoint("/".env("CLOVER_MERCHANT_ID")."/orders");
    $this->setRequestPayload($params);
    return new Resource($this->getResourceConfig());
  }

  public function customers ($params = []) {
    $this->setEndpoint("/".env("CLOVER_MERCHANT_ID")."/customers");
    $this->setRequestPayload($params);
    return new Resource($this->getResourceConfig());
  }

  public function pakms ($params = []) {
    $this->setEndpoint(preg_replace('/clover.com(.)+$/', '', env("CLOVER_URL"))."clover.com");
    $this->setRequestPayload($params);
    return new Resource($this->getResourceConfig());
  }

  
}