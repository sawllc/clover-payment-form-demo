<?php

namespace App\Clients\Clover;

use GuzzleHttp\Psr7;

class Resource {

  private $Params = false;
  private $isDebug = false;

  private $method;
  private $request;
  private $endpoint;
  private $query;
  private $body;
  private $headers;


  function __construct(Object $Params) {
    $this->Params         =       $Params;
    $this->Client         =       new \GuzzleHttp\Client();
  }





  private function setHeaders ()
  {
    $this->headers   =        array_filter([
          "Authorization"       => ($this->Params->auth_token ? "Bearer {$this->Params->auth_token}" : false),
          "accept"              => "application/json"
      ]);
  }

  private function buildRequest ($method)
  {
    $this->method         =     $method;
    $this->setHeaders();


    if(is_object($this->Params)) {

      if(in_array($this->method, ['GET']) && property_exists($this->Params, 'query')) {
        if(is_array($this->Params->query) && array_key_exists("debug", (array)$this->Params->query)) {
          $this->isDebug    =    !!$this->Params->query["debug"];
          unset($this->Params->query["debug"]);
        }

        $this->query        =     http_build_query($this->Params->query);
      }

      if(in_array($this->method, ['POST', 'PUT', 'PATCH']) && property_exists($this->Params, 'body')) {
        if(is_array($this->Params->body) && array_key_exists("debug", (array)$this->Params->body)) {
          $this->isDebug    =    !!$this->Params->body["debug"];
          unset($this->Params->body["debug"]);
        }

        $this->body        =      (array)$this->Params->body;
      }
    }
  }





  private function handleError__ClientException ($Exception, $method, $endpoint, $request) 
  {
    \Log::error("[CLIENT-EXCEPTION] FAILED To complete successful request to AgencyBloc API.  ",[$Exception->getMessage(), Psr7\str($Exception->getRequest()), Psr7\str($Exception->getResponse()),[
        "method"    =>  $method,
        "endpoint"  =>  $endpoint,
        "request"   =>  $request
    ]]);

    return new Response((object)[
        "message"   =>  $Exception->getMessage(),
        "method"    =>  $method,
        "endpoint"  =>  $endpoint,
        "request"   =>  $request
    ]);
  }

  private function handleError__ServerException ($Exception, $method, $endpoint, $request) 
  {
    \Log::error("[SERVER-EXCEPTION] FAILED To complete successful request to AgencyBloc API.  ",[$Exception->getMessage(), Psr7\str($Exception->getRequest()), Psr7\str($Exception->getResponse()),[
        "method"    =>  $method,
        "endpoint"  =>  $endpoint,
        "request"   =>  $request
    ]]);

    return new Response((object)[
        "message"   =>  $Exception->getMessage(),
        "method"    =>  $method,
        "endpoint"  =>  $endpoint,
        "request"   =>  $request
    ]);
  }

  private function performRequest($request, $returnsMany)
  {

    $request      =     array_merge($request, ['headers' => $this->headers]);
    $request      =     $this->isDebug ? array_merge($request, ["debug" => 1]) : $request;

    try {
      return new Response($this->Client->request($this->method, $this->endpoint, $request), $returnsMany);
    }

    // GuzzleHttp\Exception\ClientException = 400
    catch(\GuzzleHttp\Exception\ClientException $ex) {
        return $this->handleError__ClientException($ex, $method, $endpoint, $request);
    }

    // GuzzleHttp\Exception\ServerException = 500
    catch(\GuzzleHttp\Exception\ServerException $ex) {
        return $this->handleError__ServerException($ex, $method, $endpoint, $request);
    }
  }











  public function search () 
  {
    // build the request payload & 
    // set the request auth params.
    $this->buildRequest("GET");

    // set the request endpoint.
    $endpoint         =       rtrim($this->Params->endpoint, "/");
    $this->endpoint   =       $this->query ? "$endpoint?{$this->query}" : $endpoint;

    // perform request
    return $this->performRequest(($this->body ? ["form_params" => $this->body] : []), true);
  }

  public function create () 
  {
    // build the request payload & 
    // set the request auth params.
    $this->buildRequest("POST");

    // set the request endpoint.
    $endpoint         =       rtrim($this->Params->endpoint, "/");
    $this->endpoint   =       $this->query ? "$endpoint?{$this->query}" : $endpoint;

    // perform request
    return $this->performRequest(($this->body ? ["form_params" => $this->body] : []), false);
  }

  public function get () 
  {
    // build the request payload & 
    // set the request auth params.
    $this->buildRequest("GET");

    // set the request endpoint.
    $endpoint         =       rtrim($this->Params->endpoint, "/");
    $this->endpoint   =       $this->query ? "$endpoint?{$this->query}" : $endpoint;

    // perform request
    return $this->performRequest(($this->body ? ["form_params" => $this->body] : []), false);
  }

  public function update () 
  {
    // build the request payload & 
    // set the request auth params.
    $this->buildRequest("PUT");

    // set the request endpoint.
    $endpoint         =       rtrim($this->Params->endpoint, "/");
    $this->endpoint   =       $this->query ? "$endpoint?{$this->query}" : $endpoint;

    // perform request
    return $this->performRequest(["form_params" => $request], false);
  }
}
