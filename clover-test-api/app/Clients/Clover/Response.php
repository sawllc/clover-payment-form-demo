<?php

namespace App\Clients\Clover;

class Response {

  private $Response = false;
  private $Success = false;
  private $Error = false;
  private $returnsMany = true;





  function __construct($GuzzleResponse, $returnsMany = null) 
  {
    // boolean flag indicating if this request 
    // resource should return one or many response
    // records.
    $this->returnsMany              =       $returnsMany === true || $returnsMany === false ? $returnsMany : $this->returnsMany;


    // break down response & extract response body content.
    $class                          =       $GuzzleResponse && is_object($GuzzleResponse) ? get_class($GuzzleResponse) : false;
    if(!$class)                             return;


    // if the class is a GuzzleResponse, we can proceed
    // as normal to parse the response object.
    if($class == "GuzzleHttp\Psr7\Response")  $this->parse($GuzzleResponse);

    // if the class is std, it's an error object
    // from the client request resource.  the HTTP
    // request to Clover probably never executed.
    if($class == "stdClass")                  $this->Error = $GuzzleResponse;
  }



  public function __get ($attrib) 
  {
    if($attrib == "records")
      return $this->getRecords();
    else if($attrib == "pagination")
      return $this->getPagination();
  }

  private function parse ($GuzzleResponse)
  {
    $this->Response       =       $GuzzleResponse;

    if($GuzzleResponse->getStatusCode() >= 200 && $GuzzleResponse->getStatusCode() < 202) {
      $this->Success      =       json_decode($this->Response->getBody()->getContents(), TRUE);
    }

    else {
      $this->Error        =       is_array(($error = json_decode($this->Response->getBody()->getContents(), TRUE))) && array_key_exists("data", $error) 
                                    ? (object)$error["data"] 
                                    : $this->Error;
    }
  }

  public function success () 
  {
    return $this->Response && ($this->Response->getStatusCode() >= 200 && $this->Response->getStatusCode() < 202);
  }

  public function isEmpty () 
  {
    return $this->success() && $this->Response->getStatusCode() == 204;
  }

  private function getSingle ()
  {
    $success            =       [];

    if($this->Success) {
      foreach($this->Success as $attrib => $value)
        $success[$attrib] =     $value;
    }

    if(array_keys($success)[0] == "Agencybloc Response")
        $success         =      array_shift($success);

    return                      (object)$success;
  }

  private function getMany ()
  {
    if($this->Success && is_array($this->Success) && array_keys($this->Success)[0] == "elements")
      return collect(array_filter($this->Success['elements']));

    return collect(array_filter($this->Success));
  }

  public function getRecords () 
  {
    if($this->success()) {
      return !$this->isEmpty() && is_array($this->Success)
          ? ($this->returnsMany ? $this->getMany() : $this->getSingle())
          : ($this->isEmpty() ? collect([]) : false);
    }
  }

  public function getPagination () 
  {
    if($this->success()) {
      return $this->isEmpty()
          ? ((object)["per_page" => 0, "count" => 0, "page" => 0, "more_records" => false])
          : (array_key_exists("info", $this->Success) ? (object)$this->Success["info"] : false);
    }
  }

  public function getError () 
  {
    return $this->Error;
  }
}