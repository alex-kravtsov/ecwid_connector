<?php
/**
* При запуске шаблона ему всегда передаются два глобальных, для данного сценария, объекта:
* $request_data - свойства объекта соответствуют параметрам, переданным системой Ecwid при передаче оповещения
* $orders_data - объект, полученный от системы Ecwid в результате запроса к OrdersAPI
* Примеры использования см. ниже
*
*/
?>
<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8" />
  </head>

  <body>

    <h1>Пример использования объекта <i>$request_data</i></h1>

    <table>

      <thead>
        <tr>
          <th>Параметр</th>
          <th>Значение</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <td>ID Заказа</td>
          <?php // Отображаем ID заказа из оповещения Ecwid ?>
          <td><?php echo $request_data->order_id ?></td>
        </tr>
      </tbody>

      <tfoot></tfoot>

    </table>

    <h1>Пример использования объекта <i>$orders_data</i></h1>

    <?php // Отображаем названия товаров из заказа ?>
    <?php $products = $orders_data->orders[0]->items ?>

    <ul>
      <?php foreach($products as $product): ?>
        <li><?php echo $product->name ?></li>
      <?php endforeach ?>
    </ul>

  </body>

</html>
