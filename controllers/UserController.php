<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
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
                        'actions' => ['deactivate', 'activate', 'create', 'edit'],
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
                Yii::$app->authManager->assign(Yii::$app->authManager->getRole('employee'), $userModel->id);
                Yii::$app->session->setFlash('success', 'User Created');
                return $this->redirect(['/admin/view']);
            } else {
                Yii::$app->session->setFlash('error', 'User Not Created');
                return $this->redirect(['/admin/view']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'User Not Created');
            return $this->redirect(['/admin/view']);
        }
    }

    public function actionEdit($id)
    {
        $model = new \app\models\UserEditForm();
        $model->roles = array_keys(Yii::$app->authManager->getRolesByUser($id));
        $user= User::findOne($id);
        $model->id = $user->id;
        $model->username = $user->username;
        $model->first_name = $user->first_name;
        $model->last_name = $user->last_name;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            // $user = User::findOne(Yii::$app->user->id);
            $user->username = $model->username;
            $user->first_name = $model->first_name;
            $user->last_name = $model->last_name;
            if ($model->password != '' && $model->password == $model->password_repeat) {
                $user->setPassword($model->password);
            }
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'User Updated');
                return $this->redirect(['/admin/view']);
            } else {
                Yii::$app->session->setFlash('error', 'User Not Updated');
                return $this->redirect(['/admin/view']);
            }
        } else {
            return $this->render('/admin/_user_sign_up', [
                'model' => $model,
                'edit'  => true,
            ]);
        }
    }
}
