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

    public function actionDeleteEdit($id)
    {
        $model = $this->findModel($id);
        $workorder_id = $model->workorder_id;
        $model->delete();
        return $this->redirect(['/workorder/edit', 'id' => $workorder_id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
        }
        return $this->render('_form', [
            'workorder_id' => $model->workorder_id,
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
