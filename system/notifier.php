<?php

class bapNotifier {

  private static $_instance = null;

  public function sendMessage(){

    $categories = $this->_getProductCategories();

    if(!empty($categories) ){

      $meta_data = $this->_getMessageMeta($categories);

      if(!$meta_data) throw new Exception('Invalid metadata.');

      $message_body = $this->_renderTemplate($meta_data->template);

      $this->_exec(array(
        'message_from'=>$meta_data->message_from,
        'message_to'=>$meta_data->message_to,
        'message_body'=>$message_body,
      ));

    }

  }

  private function _exec($options){

    require_once BAP_BASE_PATH . '/lib/swift_mailer/swift_required.php';

    $message = Swift_Message::newInstance()
      ->setSubject('Order status notification')
      ->setFrom($options['message_from'])
      ->setTo($options['message_to'])
      ->setBody($options['message_body'])
    ;

    $type = $message->getHeaders()->get('Content-Type');

    $type->setValue('text/html');
    $type->setParameter('charset', 'utf-8');

    $transport = Swift_MailTransport::newInstance();

    $mailer = Swift_Mailer::newInstance($transport);

    $result = $mailer->send($message);

  }

  private function _renderTemplate($template){

    $request_data = bapFactory::getRequest()->getRequestData();
    $orders_data = bapFactory::getRPC()->getOrdersData();

    if(!ob_start() ) throw new Exception("Cannot start output buffering.");

    require_once BAP_BASE_PATH . '/templates/' . $template . '.php';

    return ob_get_clean();

  }

  private function _getMessageMeta($categories){

    $config = bapFactory::getNotifierConfig();

    $items = $config->getItems();

    foreach($items as $item){

      foreach($categories as $category_id){

        $cats = $item['categories'];

        foreach($cats as $cat_id){

          if($category_id == $cat_id){

            $meta_data = new stdClass();

            $meta_data->message_from = $item['mail_from'];
            $meta_data->message_to = $item['mail_to'];
            $meta_data->template = $item['template'];

            return $meta_data;

          }

        }// end foreach cats

      }// end foreach categories

    }// end foreach items

    return false;

  }

  private function _getProductCategories(){

    $rpc = bapFactory::getRPC();
    $orders_data = $rpc->getOrdersData();

    $categories = array();

    if(!empty($orders_data->orders) and is_array($orders_data->orders) ){

      $orders = $orders_data->orders;

      foreach($orders as $order){

        $products = $order->items;

        foreach($products as $product){

          $category_exists = false;

          foreach($categories as $category_id){
            if($category_id == $product->categoryId){
              $category_exists = true;
              break;
            }
          }

          if(!$category_exists) $categories[] = $product->categoryId;

        }// end foreach products

      }// end foreach orders

    }

    return $categories;

  }

  public static function getInstance(){
    if(empty(self::$_instance) ) self::$_instance = new bapNotifier();
    return self::$_instance;
  }

  private function __construct(){
  }

}
