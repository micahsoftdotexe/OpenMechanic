<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class NoteController extends SafeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                    'create' => ['POST'],
                    'update' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                //'only' => ['get-batch-data'],
                'rules' => [
                    [
                        'actions' => ['create', 'delete', 'update'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createNote'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['editOwnNote'],
                        'roleParams' => ['id' => Yii::$app->request->get('id')],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteOwnNote', 'deleteNote'],
                        'roleParams' => ['id' => Yii::$app->request->get('id')],
                    ],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Note();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/order/edit', 'id' => $model->order_id]);
        }
        Yii::$app->session->setFlash('error', "Note Save Error");
        return $this->redirect(['/order/edit', 'id' => $model->order_id]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $order_id = $model->order_id;
        $model->delete();
        return $this->redirect(['/order/edit', 'id' => $order_id]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
            Yii::$app->session->setFlash('error', "Note Save Error");
        }
        return $this->redirect(['/order/edit', 'id' => $model->order_id]);
    }
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
