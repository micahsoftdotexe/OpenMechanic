<?php

namespace app\controllers;

use Yii;
use app\models\Workorder;
use app\models\Automobile;
use app\models\WorkorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class AutomobileController extends SafeController
{

    /**
     * {@inheritdoc}
     */
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
                        'actions' => ['initial-create', 'ajax-initial-create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionInitialCreate()
    {
        $model = new \app\models\AutomobileForm();
        // if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
        //     Yii::$app->session->setFlash('error', 'Automobile Error');
        // }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $autoModel = new Automobile();
            $ownModel = new \app\models\Owns();
            $autoModel->vin = $model->vin;
            $autoModel->make = $model->make;
            $autoModel->model = $model->model;
            $autoModel->year = $model->year;
            $autoModel->motor_number = $model->motor_number;
            if ($autoModel->save()) {
                $ownModel->customer_id = $model->customer_id;
                $ownModel->automobile_id = $autoModel->id;
                if (!$ownModel->save()) {
                    Yii::$app->session->setFlash('error', 'Own Error');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Automotive Error');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Form Error');
        }
        $this->redirect(\yii\helpers\Url::to(['/workorder/create']));
    }

    public function actionAjaxInitialCreate()
    {
        $model = new \app\models\AutomobileForm();
        // if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
        //     Yii::$app->session->setFlash('error', 'Automobile Error');
        // }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $autoModel = new Automobile();
            $ownModel = new \app\models\Owns();
            $autoModel->vin = $model->vin;
            $autoModel->make = $model->make;
            $autoModel->model = $model->model;
            $autoModel->year = $model->year;
            $autoModel->motor_number = $model->motor_number;
            if ($autoModel->save()) {
                $ownModel->customer_id = $model->customer_id;
                $ownModel->automobile_id = $autoModel->id;
                if (!$ownModel->save()) {
                    Yii::$app->session->setFlash('error', 'Own Error');
                    $autoModel->delete();
                    return 400;
                }
                return json_encode(['id' => $autoModel->id, 'text' => $model->make.' '.$model->model.' '.$model->year]);
            } else {
                Yii::$app->session->setFlash('error', 'Automotive Error');
                return 400;
            }
        } else {
            Yii::$app->session->setFlash('error', 'Form Error');
            return 400;
        }
    }
    // public function actionGetAutomobile() {
    //     return 200;
    // }
}
