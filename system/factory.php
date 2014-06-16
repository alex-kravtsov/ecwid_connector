<?php

class bapFactory {

  public static function getRequest(){
    require_once BAP_BASE_PATH . '/system/request.php';
    return bapRequest::getInstance();
  }

  public static function getRPC(){
    require_once BAP_BASE_PATH . '/system/rpc.php';
    return bapRPC::getInstance();
  }

  public static function getNotifier(){
    require_once BAP_BASE_PATH . '/system/notifier.php';
    return bapNotifier::getInstance();
  }

  public static function getNotifierConfig(){
    require_once BAP_BASE_PATH . '/config/notifier.php';
    return bapNotifierConfig::getInstance();
  }

}
