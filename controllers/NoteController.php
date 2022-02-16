<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class NoteController extends Controller
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
                        'actions' => ['create', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Note();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
        }
        Yii::$app->session->setFlash('error', "Note Save Error");
        return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $workorder_id = $model->workorder_id;
        $model->delete();
        return $this->redirect(['/workorder/edit', 'id' => $workorder_id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
            Yii::$app->session->setFlash('error', "Note Save Error");
        }
        return $this->redirect(['/workorder/edit', 'id' => $model->workorder_id]);
    }
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
