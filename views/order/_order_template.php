<?php
use \app\models\Order;
use \app\models\QuantityType;
?>

<div id="company_info">
  <h2> <?= Yii::$app->params['companyName'] ?> </h1>
  <h3> <?= Yii::$app->params['companyAddress'] ?> </h3>
  <h3> <?= Yii::$app->params['companyPhoneNumber'] ?> </h3>
</div>

<div id="customer_info">
  <table class="table table-bordered">
    <caption style="font-weight: 1000">Customer Information</caption>
    <tr id="name">
      <th scope="row"> Name: </th>
      <td> <?= $order->customer->fullName ?> </td>
    </tr>
    <?php if ($order->customer->phone_number_1) : ?>
    <tr id="number1">
      <th scope="row"> Phone Number: </th>
      <td> <?= $order->customer->phone_number_1 ?> </td>
    </tr>
    <?php endif; ?>
    <?php if ($order->customer->phone_number_2) : ?>
    <tr id="number2">
      <th scope="row">Phone Number 2: </th>
      <td> <?= $order->customer->phone_number_2 ?> </td>
    </tr>
    <?php endif; ?>
  </table>
</div>
<div id="parts">
  <table class="table table-bordered">
    <caption style="font-weight: 1000">Parts</caption>
    <tr>
      <th scope="col">Part</th>
      <th scope="col">Quantity</th>
      <th scope="col">Price</th>
    </tr>
    <?php foreach ($order->parts as $part) : ?>
    <tr>
      <td><?= $part->description ?></td>
        <?php if ($part->quantity_type_id) : ?>
          <td><?= $part->quantity . ' (' . QuantityType::findOne($part->quantity_type_id)->description . ')' ?></td>
        <?php else : ?>
          <td><?= $part->quantity?></td>
        <?php endif; ?>
      <td class="text-right"><?= '$' . number_format(round($part->total, 2), 2) ?></td>
      <!-- class="text-right" -->
    </tr>
    <?php endforeach; ?>
    <tr>
      <th scope="row">Total</th>
      <td></td>
      <td class="text-right"><?= '$' . number_format(round($order->partTotal, 2), 2) ?> </td>
    </tr>
  </table>
</div>
<div id="labor">
  <table class="table table-bordered">
    <caption style="font-weight: 1000">Labor</caption>
    <tr>
      <th scope="col">Description</th>
      <th scope="col">Total</th>
      <th scope="col">Notes</th>
    </tr>
    <?php foreach ($order->labors as $labor) : ?>
    <tr>
      <td><?= $labor->description ?></td>
      <td><?= '$'.$labor->total ?></td>
      <td><?= $labor->notes ?></td>
    </tr>
    <?php endforeach; ?>
    <tr>
      <th scope="row">Total</th>
      <td><?= '$' . number_format(round($order->laborTotal, 2), 2) ?> </td>
      <td></td>
    </tr>
  </table>
</div>
<?php if ($order->notes) : ?>
  <table class="table table-bordered">
    <caption style="font-weight: 1000">Notes</caption>
    <?php foreach ($order->notes as $note) : ?>
    <tr>
      <td><?= $note->text ?></td>
    </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>
<div id="total">
  <table class="table table-bordered" style="width: 30%">
    <caption style="font-weight: 1000">Total</caption>
    <tr>
      <th scope="col">Subtotal</th>
      <td class="text-right"><?= '$'. number_format(round($order->subtotal, 2), 2) ?></td>
    </tr>
    <tr>
      <th scope="col">Tax</th>
      <td class="text-right"><?= '$'. number_format(round($order->taxAmount, 2), 2) ?></td>
    </tr>
    <tr>
      <th scope="col">Total</th>
      <td class="text-right"><?= '$'.number_format(round($order->total, 2), 2) ?></td>
    </tr>
  </table>
</div>

