<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class UserController extends SafeController
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
                'rules' => [
                    [
                        'actions' => ['deactivate', 'activate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionDeactivate($id)
    {
        $user = \app\models\User::findOne($id);
        if ($id != Yii::$app->user->id){
            $user->status = 0;
            $user->save();
        } else {
            Yii::$app->session->setFlash('error', 'You Cannot Deactivate Yourself, Silly.');
        }
        
        return $this->redirect(['/admin/view']);

    }

    public function actionActivate($id)
    {
        $user = \app\models\User::findOne($id);
        $user->status = 1;
        $user->save();
        return $this->redirect(['/admin/view']);
    }
}
