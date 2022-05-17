<?php

namespace app\controllers;

use Yii;
use app\models\Automobile;
use app\models\AutomobileForm;
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
            // 'verbs' => [
            //     'class' => VerbFilter::class,
            //     'actions' => [
            //         'delete' => ['POST'],
            //     ],
            // ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['initial-create', 'ajax-initial-create', 'create'],
                        'allow' => true,
                        'roles' => ['createAuto'],
                    ],
                    [
                        'actions' => ['customer-edit'],
                        'allow' => true,
                        'roles' => ['editAuto'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteAuto'],
                    ]
                ],
            ],
        ];
    }
    public function actionCreate($customer_id)
    {
        $model = new AutomobileForm();
        $model->customer_id = $customer_id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $automobile = Automobile::formToAutomobile($model, new Automobile());
            $owns = new \app\models\Owns();
            $owns->customer_id = $model->customer_id;
            $automobile->save();
            $owns->automobile_id = $automobile->id;
            $owns->save();
            return $this->redirect(['/customer/edit', 'id' => $model->customer_id]);
        }
        return $this->render('_form', [
            'model' => $model,
            'change_form' => false,
            'create' => true,
        ]);
    }
    // public function actionInitialCreate()
    // {
    //     $model = new \app\models\AutomobileForm();
    //     // if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
    //     //     Yii::$app->session->setFlash('error', 'Automobile Error');
    //     // }
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         $autoModel = new Automobile();
    //         $ownModel = new \app\models\Owns();
    //         $autoModel->vin = $model->vin;
    //         $autoModel->make = $model->make;
    //         $autoModel->model = $model->model;
    //         $autoModel->year = $model->year;
    //         $autoModel->motor_number = $model->motor_number;
    //         if ($autoModel->save()) {
    //             $ownModel->customer_id = $model->customer_id;
    //             $ownModel->automobile_id = $autoModel->id;
    //             if (!$ownModel->save()) {
    //                 Yii::$app->session->setFlash('error', 'Own Error');
    //             }
    //         } else {
    //             Yii::$app->session->setFlash('error', 'Automotive Error');
    //         }
    //     } else {
    //         Yii::$app->session->setFlash('error', 'Form Error');
    //     }
    //     $this->redirect(\yii\helpers\Url::to(['/order/create']));
    // }

    public function actionAjaxInitialCreate()
    {
        $model = new \app\models\AutomobileForm();
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
                    $autoModel->delete();
                    return json_encode(['status' => 400, 'message' => $model->getErrors()]); ;
                }
                return json_encode(['id' => $autoModel->id, 'text' => $model->make.' '.$model->model.' '.$model->year]);
            } else {
                return json_encode(['status' => 400, 'message' => $model->getErrors()]);
            }
        } else {
            return json_encode(['status' => 400, 'message' => $model->getErrors()]);
        }
    }

    public function actionCustomerEdit($id)
    {
        $model = Automobile::findOne($id);
        $modelForm = AutomobileForm::automobileToForm($model, new AutomobileForm());
        //$model->scenario = 'update';
        if ($modelForm->load(Yii::$app->request->post()) && $modelForm->validate()) {
            $model = Automobile::formToAutomobile($modelForm, $model);
            $model->save();
        } else {
            if (!$modelForm->validate()) {
                Yii::$app->getSession()->setFlash('error', 'Could Not Save Automobile');
            } else {
                return $this->render('_form', ['model' => $modelForm, 'change_form' => false, 'create' => false]);
            }
        }
        return $this->redirect(['/customer/edit', 'id' => $modelForm->customer_id]);

        // return $this->render('edit', [
        //     'model' => $model,
        // ]);
    }

    public function actionDelete($id) {
        $model = Automobile::findOne($id);
        $customer_id = \app\models\Owns::findOne(['automobile_id' => $id])->customer_id;
        if (\app\models\Order::find()->where(['automobile_id' => $id])->exists()) {
            Yii::$app->session->setFlash('error', 'Automobile is in use');
        } else {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Automobile Deleted');
        }
        return $this->redirect(['/customer/edit', 'id' => $customer_id]);
    }
}
