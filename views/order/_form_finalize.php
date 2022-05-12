<?php

use app\models\Order;
use yii\helpers\Html;
?>
<table class="table table-bordered">
    <tr>
        <th scope="col">Subtotal ($)</th>
        <th scope="col">Tax ($)</th>
        <th scope="col">Total ($)</th>
    </tr>
    <tr>
        <td><?= '$'.number_format(round($order->subtotal, 2), 2) ?></td>
        <td><?= '$'.number_format(round($order->taxAmount, 2), 2) ?></td>
        <td><?= '$'.number_format(round($order->total, 2), 2) ?></td>
    </tr>
</table>
<?= Html::a('Generate Order', ['generate-order', 'id' => $order->id], ['class' => 'btn btn-primary', 'id' => 'generate-order']) ?>
