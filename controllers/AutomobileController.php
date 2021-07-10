<?php

namespace app\controllers;

use Yii;
use app\models\Workorder;
use app\models\Automobile;
use app\models\WorkorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AutomobileController extends Controller {

    public function actionGetAutomobile() {
        if(Yii::$app->request->post('id') && $app->request->post('post')) {
            
            $id = Yii::$app->request->post('id');
            $model = new Workorder();
            $post = Yii::$app->request->post('post');
            echo $form->field($model, 'customer_id')->label(Yii::t('app', 'Customer'))->widget(Select2::classname(), [
                'data' => \app\models\Automobile::getIds($id),
                'options' => [
                    'id'   => 'automobile_id',
                    'placeholder' => '--'.Yii::t('app', 'Select One').'--',
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
        }
    }

}