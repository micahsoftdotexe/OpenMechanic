<?php

namespace app\controllers;

use Yii;
use app\models\Workorder;
use app\models\Automobile;
use app\models\WorkorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AutomobileController extends Controller {

    public function actionGetAutomobile() {
        return 200;
    }

}