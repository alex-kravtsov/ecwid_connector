<?php

class bapRequest {

  private static $_instance = null;

  private $_request_data = null;

  private $_valid = false;

  public function validate(){
    $data = new stdClass();
    foreach($_POST as $key=>$value) $data->$key = $value;
    if(!empty($data->order_id) ){
      $this->_request_data = $data;
      $this->_valid = true;
    }
  }

  public function isValid(){
    return $this->_valid;
  }

  public function getRequestData(){
    return $this->_request_data;
  }

  public static function getInstance(){
    if(empty(self::$_instance) ) self::$_instance = new bapRequest();
    return self::$_instance;
  }

  private function __construct(){
  }

}
