<?php

namespace app\controllers;
use Yii;
use yii\web\Controller;

class SafeController extends Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            if (!\app\models\User::findOne(Yii::$app->user->identity->isActive)) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Your Account Has Been Deactivated: Please Contact Administrator.', false);
                $this->goHome();
                return false;
            }
        }
        return parent::beforeAction($action);
    }
}
