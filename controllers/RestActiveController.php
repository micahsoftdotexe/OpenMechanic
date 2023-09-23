<?php

namespace app\controllers;
use Yii;
use yii\rest\ActiveController;

class RestActiveController extends ActiveController
{
    public function beforeAction($action)
    {
        //your code

        if (Yii::$app->getRequest()->getMethod() === 'OPTIONS') {
            parent::beforeAction($action);
            Yii::$app->getResponse()->getHeaders()->set('Content-Type', 'text/plain');
            Yii::$app->end();
        }

        return parent::beforeAction($action);
    }
}