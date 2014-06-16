<?php

class bapNotifierConfig {

  private static $_instance = null;

  private $_items = null;

  private function __construct(){

    $this->_items = array(

      array(
        'mail_from'=>'from1@example.com', // Адрес почты, от которого будет выслано сообщение
        'mail_to'=>'to1@example.com', // Адрес получателя сообщения
        'template'=>'default', // Имя шаблона сообщения (имя файла в паке templates без расширения .php)
        'categories'=>array(211,9645903,243), // Список номеров категорий товаров для данного типа сообщения
      ),

      array(
        'mail_from'=>'from2@example.com',
        'mail_to'=>'to2@example.com',
        'template'=>'default',
        'categories'=>array(1,2,3,4),
      ),

    );

  }

  public function getItems(){
    return $this->_items;
  }

  public static function getInstance(){
    if(empty(self::$_instance) ) self::$_instance = new bapNotifierConfig();
    return self::$_instance;
  }

}
