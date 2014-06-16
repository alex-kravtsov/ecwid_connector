<?php

define("BAP_BASE_PATH", dirname(__FILE__) );

require_once BAP_BASE_PATH . '/config/config.php';
require_once BAP_BASE_PATH . '/system/factory.php';

try {

  if(!date_default_timezone_set(bapConfig::TIMEZONE) ) throw new Exception("Invalid timezone identifier.");

  if(!mb_internal_encoding(bapConfig::INTERNAL_ENCODING) ) throw new Exception("Cannot set internal encoding.");

  if(!mb_regex_encoding(bapConfig::INTERNAL_ENCODING) ) throw new Exception("Cannot set regex encoding.");

  $request = bapFactory::getRequest();
  $request->validate();

  if($request->isValid() ){

    header('HTTP/1.0 200 OK', true, 200);

    $rpc = bapFactory::getRPC();
    $rpc->loadData();

    $notifier = bapFactory::getNotifier();
    $notifier->sendMessage();

  }
  else {
    header('HTTP/1.0 400 Bad Request', true, 400);
  }

}
catch(Exception $e){
  echo "Error:\n";
  echo "Message: " . $e->getMessage() . "\n";
  echo "File: " . $e->getFile() . "\n";
  echo "Line: " . $e->getLine() . "\n";
  echo "Trace:\n";
  echo $e->getTraceAsString() . "\n";
}
