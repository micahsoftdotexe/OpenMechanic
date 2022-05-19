<?php

namespace app\controllers;

use Yii;
use app\models\Customer;
use yii\filters\AccessControl;
use app\models\CustomerSearch;
use app\models\Owns;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends SafeController
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
                        'actions' => ['ajax-initial-create'],
                        'allow' => true,
                        'roles' => ['createCustomer'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['edit'],
                        'allow' => true,
                        'roles' => ['editCustomer'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['createCustomer'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['deleteCustomer'],
                    ],

                ],
            ],
        ];
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    // public function actionView($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post())) {
            if (Customer::findOne(['first_name' => $model->first_name, 'last_name' => $model->last_name])) {
                Yii::$app->session->setFlash('error', 'Customer already exists');
            } else {
                if ($model->save()) {
                    return $this->redirect(['index']);
                }
            }
            //$model->fullName = $model->firstName.' '.$model->lastName;\
        }

        return $this->render('_form', [
            'model' => $model,
            'change_form' => false,
            'create' => true,
            'view' => false
        ]);
    }

    public function actionView($id, $tab = null) {
        $tab = Yii::$app->request->cookies->getValue('customerTab', (isset($_COOKIE['customerTab']))? $_COOKIE['customerTab']:'tabCustomersLink');
        $model = Customer::findOne($id);
        $automobileDataProvider = new ActiveDataProvider([
            'query' => Customer::findOne(['id' => $id])->getAutomobiles(),
        ]);
        $orderDataProvider = new ActiveDataProvider([
            'query' => \app\models\Order::find()->where(['customer_id' => $model->id]),
        ]);
        return $this->render('view', [
            'model' => $model,
            'automobileDataProvider' => $automobileDataProvider,
            'orderDataProvider' => $orderDataProvider,
            'tab' => $tab,
            //'view' => false
        ]);
    }

    public function actionEdit($id, $tab = null)
    {
        if ($tab) {
            setcookie('customerTab', $tab, 0, '/');
            return $this->redirect(['edit', 'id' => $id]);
        }
        $tab = Yii::$app->request->cookies->getValue('customerTab', (isset($_COOKIE['customerTab']))? $_COOKIE['customerTab']:'tabCustomersLink');
        $model = Customer::findOne($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
        }
        $automobileDataProvider = new ActiveDataProvider([
            'query' => Customer::findOne(['id' => $id])->getAutomobiles(),
        ]);
        $orderDataProvider = new ActiveDataProvider([
            'query' => \app\models\Order::find()->where(['customer_id' => $model->id]),
        ]);
        return $this->render('edit', [
            'model' => $model,
            'automobileDataProvider' => $automobileDataProvider,
            'orderDataProvider' => $orderDataProvider,
            'tab' => $tab,
            'view' => false
        ]);
    }

    public function actionAjaxInitialCreate()
    {
        $model = new \app\models\Customer();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if (Customer::findOne(['first_name' => $model->first_name, 'last_name' => $model->last_name])) {
                // Yii::debug('Here', 'dev');
                return json_encode(['status' => 400, 'message' => 'Customer already exists']);
            }
            if ($model->save()) {
                return json_encode(['status' => 200, 'id' => $model->id, 'text' => $model->first_name. ' '. $model->last_name]);
            }
        }
        Yii::debug('Out Here', 'dev');
        return json_encode(['status' => 400, 'message' => $model->getErrors()]);
    }

    /**
     * Updates an existing Customer model.
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
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\app\models\Order::findOne(['customer_id' => $id])) {
            Yii::$app->session->setFlash('error', 'Cannot Delete Customer, Orders Exist');
            return $this->redirect(['index']);
        }
        $customer = Customer::findOne($id);
        $automobiles = $customer->automobiles;
        foreach ($automobiles as $automobile) {
            $automobile->delete();
        }
        //$this->findModel($id)->delete();
        Customer::findOne($id)->delete();

        Yii::$app->session->setFlash('success', 'Customer Deleted');

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
