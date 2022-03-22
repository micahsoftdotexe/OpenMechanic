<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

class AdminController extends SafeController
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
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionView()
    {
        $searchModel = new \app\models\UserSearch();
        $userDataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tab = Yii::$app->request->cookies->getValue('admintab', (isset($_COOKIE['admintab']))? $_COOKIE['admintab']:'tabSystemLink');
        return $this->render('view', [
            'userDataProvider' => $userDataProvider,
            'userSearchModel' => $searchModel,
            'tab' => $tab
        ]);
    }
}
