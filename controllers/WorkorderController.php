<?php

namespace app\controllers;

use Yii;
use app\models\Workorder;
use app\models\WorkorderSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * WorkorderController implements the CRUD actions for Workorder model.
 */
class WorkorderController extends SafeController
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
                        'actions' => ['create','get-automobiles', 'index', 'edit', 'create-template', 'delete', 'update-template', 'update-notes'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Workorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WorkorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Workorder model.
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
     * Creates a new Workorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        //$model = null;
        // \Yii::debug($id,
        //      'dev'  // devlog file.  See components->log->dev defined in /config/web.php
        // );
        $model = new Workorder();
        //$model->scenario = Workorder::SCENARIO_STEP1;

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
        $model = Workorder::find()->where(['id' => $id])->one();
        $partDataprovider = new ActiveDataProvider([
            'query' => \app\models\Part::find()->where(['workorder_id' => $model->id]),
        ]);
        $laborDataprovider = new ActiveDataProvider([
            'query' => \app\models\Labor::find()->where(['workorder_id' => $model->id]),
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
        $model = new Workorder();
        //Yii::debug(Yii::$app->request->post(), 'dev');
        if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('taxable')) {
            //$model->scenario = Workorder::SCENARIO_STEP2;
            $model->stage_id = \app\models\Stage::find()->where(['title' => 'Created'])->one()->id;
            if (intval(Yii::$app->request->post('taxable')) == 1) {
                $model->tax = Yii::$app->params['sales_tax'];
            } else {
                $model->tax = 0;
            }
            //$model->notes = "Replace Text Here";
            if ($model->save()) {
                $this->redirect(['edit', 'id' => $model->id, 'tab' => 'tabCustomerAutomobileLink']);
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Workorder Save Error'));
            }
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Workorder Save Error'));
            return $this->redirect(Url::base(true).'/workorder');
        }
    }

    /**
     * Updates an existing Workorder model.
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
        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Workorder Save Error'));
        return $this->render('edit', [
            'id' => $model->id,
        ]);
    }

    public function actionUpdateNotes($id)
    {
        $model = new \app\models\NotesForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $work_order_model = Workorder::find()->where(['id' => $model->workorder_id])->one();
            $work_order_model->notes = $model->note;
            if (!!!$work_order_model->save()) {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Notes Save Error'));
            }
            
        } else {
            Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Notes Save Error')); 
        }
        return $this->redirect(['edit', 'id' => $work_order_model->id]);
    }

    /**
     * Updates an existing Workorder model.
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
     * Deletes an existing Workorder model.
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
     * Finds the Workorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Workorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Workorder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public static function actionGetAutomobiles()
    {
        // \Yii::debug("before id",
        //     'dev'  // devlog file.  See components->log->dev defined in /config/web.php
        //     );
        if ($id = Yii::$app->request->post('id')) {
            return json_encode(\app\models\Automobile::getIds($id));
        } else {
            return \yii\helpers\Json::encode([
                'status' => 'error',
                'details' => 'No customer_id',
            ]);
        }
    }
}
