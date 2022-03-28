<?php

namespace app\controllers;

use Yii;
use app\models\Labor;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class LaborController extends SafeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['get-batch-data'],
                'rules' => [
                    [
                        'actions' => ['create-edit', 'delete-edit', 'update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['create-edit'],
                        'allow' => true,
                        'roles' => ['createLabor'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['editLabor'],
                    ],
                    [
                        'actions' => ['delete-edit'],
                        'allow' => true,
                        'roles' => ['deleteLabor'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreateEdit()
    {
        $model = new Labor();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/order/edit', 'id' => $model->order_id]);
        }
        Yii::$app->session->setFlash('error', $model->getErrors());
        return $this->redirect(['/order/edit', 'id' => $model->order_id]);
    }

    public function actionDeleteEdit($id)
    {
        $model = $this->findModel($id);
        $order_id = $model->order_id;
        $model->delete();
        return $this->redirect(['/order/edit', 'id' => $order_id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/order/edit', 'id' => $model->order_id]);
        }
        return $this->render('_form', [
            'order_id' => $model->order_id,
            'model' => $model,
            'edit' => true,
        ]);
    }

    /**
     * Finds the Labor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Labor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Labor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
