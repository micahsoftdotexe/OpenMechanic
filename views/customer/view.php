<?=
$this->render('edit', [
    'model' => $model,
    'automobileDataProvider' => $automobileDataProvider,
    'orderDataProvider' => $orderDataProvider,
    'tab' => $tab,
    'view' => true,
]);
