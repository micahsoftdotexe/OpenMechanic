<?php

namespace app\controllers;

use Yii;
use app\models\Labor;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LaborController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['get-batch-data'],
                'rules' => [
                    [
                        'actions' => ['create-edit', 'delete', 'delete-edit', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreateEdit()
    {
        $model = new Labor();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
        }
        Yii::$app->session->setFlash('error', $model->getErrors());
        return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
    }
}
