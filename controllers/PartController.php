<?php

namespace app\controllers;

use Yii;
use app\models\Part;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PartController implements the CRUD actions for Part model.
 */
class PartController extends Controller
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
                'only' => ['get-batch-data'],
                'rules' => [
                    [
                        'actions' => ['submit-part-form-url'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Part models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Part::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Part model.
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
     * Creates a new Part model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Part();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Part model.
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
     * Deletes an existing Part model.
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
     * Finds the Part model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Part the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Part::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }


    public function actionSubmitPartFormUrl()
    {
        if ($data = Yii::$app->request->post("Part")) {
            //$data = implode('|',$data);
            // \Yii::debug("data {$data}",
            // 'dev'  // devlog file.  See components->log->dev defined in /config/web.php
            // );
            $newPart = new Part;
            $newPart->description = $data['description'];
            $newPart->part_number = $data['part_number'];
            $newPart->margin = $data['margin'];
            $newPart->price = $data['price'];
            if($data['quantity']!="" && $data['quantity_type_id']!="" ) {
                $newPart->quantity;
            }
            if($newPart->validate()) {
                $newPart->save();
            }
            else {
                //$data = implode('|',$data);
                \Yii::debug("not getting validated: {$newPart->errors}",
                'dev'  // devlog file.  See components->log->dev defined in /config/web.php
                );
            }
            $data['id'] = $newPart->id;
            return \yii\helpers\Json::encode($data);
        }
        else {
            return \yii\helpers\Json::encode([
                'status' => 'error',
                'details' => 'No customer_id',
            ]);
        }
    }
}
