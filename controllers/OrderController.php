<?php

namespace app\controllers;

use Yii;
use app\models\Order;
use app\models\OrderSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends SafeController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete',
                    //'delete' => ['POST'],
                    'get-automobiles',
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['get-automobiles', 'index', 'edit', 'generate-order'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['create', 'create-template'],
                        'allow' => true,
                        'roles' => ['createOrder'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteOrder'],
                    ],
                    [
                        'actions' => ['update-template'],
                        'allow' => true,
                        'roles' => ['editOrder'],
                    ],
                    [
                        'actions' => ['change-stage'],
                        'allow' => true,
                        'roles' => ['changeStage'],
                        'roleParams' => ['id' => Yii::$app->request->get('id'), 'increment' => Yii::$app->request->get('increment')],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$model = null;
        // \Yii::debug($id,
        //      'dev'  // devlog file.  See components->log->dev defined in /config/web.php
        // );
        $model = new Order();

        return $this->render('create', [
            'model' => $model,
            'update' => false
            //'stage' => 1,
        ]);
    }

    public function actionEdit($id, $tab = null)
    {
        if ($tab) {
            setcookie('edittab', $tab, 0, '/');
            return $this->redirect(['edit', 'id' => $id]);
        }
        $tab = Yii::$app->request->cookies->getValue('edittab', (isset($_COOKIE['edittab']))? $_COOKIE['edittab']:'tabCustomerAutomobileLink');
        $model = Order::find()->where(['id' => $id])->one();
        $partDataprovider = new ActiveDataProvider([
            'query' => \app\models\Part::find()->where(['order_id' => $model->id]),
        ]);
        $laborDataprovider = new ActiveDataProvider([
            'query' => \app\models\Labor::find()->where(['order_id' => $model->id]),
        ]);
        return $this->render('edit', [
            'model' => $model,
            'partDataProvider' => $partDataprovider,
            'laborDataProvider' => $laborDataprovider,
            'tab' => $tab,
        ]);
    }


    public function actionCreateTemplate()
    {
        $model = new Order();
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('taxable')) {
            $model->stage = 1;
            if (intval(Yii::$app->request->post('taxable')) == 1) {
                $model->tax = Yii::$app->params['sales_tax'];
            } else {
                $model->tax = 0;
            }
            if ($model->save()) {
                $this->redirect(['edit', 'id' => $model->id, 'tab' => 'tabCustomerAutomobileLink']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Order Save Error'));
                return $this->redirect(Url::base(true).'/order');
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Order Save Error'));
            return $this->redirect(Url::base(true).'/order');
        }
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateTemplate($id)
    {
        $model = $this->findModel($id);

        if (intval(Yii::$app->request->post('taxable')) == 1) {
            $model->tax = Yii::$app->params['sales_tax'];
        } else {
            $model->tax = 0;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['edit', 'id' => $model->id]);
        }
        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Order Save Error'));
        return $this->render('edit', [
            'id' => $model->id,
        ]);
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public static function actionGetAutomobiles()
    {
        if ($id = Yii::$app->request->post('id')) {
            return json_encode(\app\models\Automobile::getIds($id));
        } else {
            return \yii\helpers\Json::encode([
                'status' => 'error',
                'details' => 'No customer_id',
            ]);
        }
    }

    public function actionChangeStage($id, $increment)
    {
        $model = Order::findOne($id);
        if ($model->canChangeStage($increment)) {
            $model->stage += $increment;
            if ($model->save()) {
                return $this->redirect(['edit', 'id' => $model->id]);
            } else {
                Yii::debug($model->getErrors(), 'dev');
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Could not change stage'));
                return $this->redirect(['edit', 'id' => $model->id]);
            }
        } else {
            Yii::debug('here', 'dev');
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Could not change stage'));
            return $this->redirect(['edit', 'id' => $model->id]);
        }
    }

    public function actionGenerateOrder($id)
    {
        $model = Order::findOne($id);
        $content = $this->renderPartial('_order_template', ['order' => $model]);
        $pdf = new \kartik\mpdf\Pdf([
            'content' => $content,
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'destination' => "I",
            'filename' => 'Order-'.$model->customer->fullName.'-'.$model->date,
            'options' => ['title' => 'Order-'.$model->customer->fullName.'-'.$model->date],
            'methods' => [
                'SetTitle' => 'Order-'.$model->customer->fullName.'-'.$model->date
            ]
        ]);
        //$pdf->SetTitle('Order-'.$model->customer->fullName.'-'.$model->date);
        return $pdf->render();
        // return $this->render('_order_template', [
        //     'order' => $model,
        // ]);
    }
}
