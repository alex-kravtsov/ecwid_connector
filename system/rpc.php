<?php

class bapRPC {

  private static $_instance = null;

  private $_orders_data = null;

  public function getOrdersData(){
    return $this->_orders_data;
  }

  public function loadData(){

    $request = bapFactory::getRequest();
    $request_data = $request->getRequestData();

    $order_id = $request_data->order_id;

    $this->_getEcwidOrder($order_id);

  }

  private function _getEcwidOrder($order_id){

    $url = sprintf(bapConfig::ECWID_ORDERS_URL_FORMAT, bapConfig::ECWID_STOREID);
    $url .= '?secure_auth_key=' . bapConfig::ECWID_ORDERAPI_SEQURE_AUTH_KEY;
    $url .= '&order=' . $order_id;

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
    //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    $error = curl_error($ch);

    curl_close($ch);

    $data = json_decode($response);

    if(empty($data) ) throw new Exception("Invalid response data.");

    $this->_orders_data = $data;

  }

  public static function getInstance(){
    if(empty(self::$_instance) ) self::$_instance = new bapRPC();
    return self::$_instance;
  }

  private function __construct(){
  }

}
