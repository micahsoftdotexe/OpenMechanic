<?php

use app\models\Order;
use yii\helpers\Html;
?>
<table class="table table-bordered">
    <tr>
        <th scope="col">Subtotal ($)</th>
        <th scope="col">Tax (%)</th>
        <th scope="col">Total ($)</th>
    </tr>
    <tr>
        <td><?= '$'.$order->subtotal ?></td>
        <td><?= round($order->tax * 100). '%' ?></td>
        <td><?= '$'.$order->total ?></td>
    </tr>
</table>
<?= Html::a('Generate Order', ['generate-order', 'id' => $order->id], ['class' => 'btn btn-primary', 'id' => 'generate-order']) ?>
