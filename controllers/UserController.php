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
                        'actions' => ['deactivate', 'activate', 'create'],
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
        if ($id != Yii::$app->user->id) {
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

    public function actionCreate()
    {
        $formModel = new \app\models\SignupForm();
        $userModel = new \app\models\User();
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate()) {
            $userModel->username = $formModel->username;
            $userModel->first_name = $formModel->first_name;
            $userModel->last_name = $formModel->last_name;
            $userModel->setPassword($formModel->password);
            $userModel->generateAuthKey();
            $userModel->status = 1;
            if ($userModel->save()) {
                Yii::$app->session->setFlash('success', 'User Created');
                return $this->redirect(['/admin/view']);
            } else {
                Yii::$app->session->setFlash('error', 'User Not Created');
                return $this->redirect(['/admin/view']);
            }
            // if ($formModel->signup()) {
            //     return $this->redirect(['/admin/view']);
            // }
        }
    }
}
