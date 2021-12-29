<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%automobile}}".
 *
 * @property int $id
 * @property string $vin
 * @property string $make
 * @property string $model
 * @property int $year
 *
 * @property Owns[] $owns
 * @property Workorder[] $workorders
 */
class Automobile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%automobile}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['vin', 'make', 'model', 'year'], 'required'],
            [['year'], 'integer'],
            [['vin'], 'string', 'max' => 17],
            [['make', 'model'], 'string', 'max' => 128],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'vin' => Yii::t('app', 'Vin'),
            'make' => Yii::t('app', 'Make'),
            'model' => Yii::t('app', 'Model'),
            'year' => Yii::t('app', 'Year'),
        ];
    }

    /**
     * Gets query for [[Owns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwns()
    {
        return $this->hasMany(Owns::className(), ['automobile_id' => 'id']);
    }

    /**
     * Gets query for [[Workorders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkorders()
    {
        return $this->hasMany(Workorder::className(), ['automobile_id' => 'id']);
    }
    public static function getIds($id)
    {
        $customer = Customer::find()->where(['id' => $id])->one();
        // \Yii::debug("after customer",
        //     'dev'  // devlog file.  See components->log->dev defined in /config/web.php
        //     );
        $models = $customer->automobiles;
        //$models = hasMany(Owns::className(), ['automobile_id' => 'id']);
        // return \yii\helpers\ArrayHelper::map($models, 'id', 'make'.' '.'model'.' '.'year');
        $results = [];
        //$integer = 0;
        //TODO: change this from using an integer key to id key
        foreach ($models as $model) {
            $results[$model->id] = $model->make.' '.$model->model.' '.$model->year;
            //$integer++;
        }
        // \Yii::debug("after array",
        //     'dev'  // devlog file.  See components->log->dev defined in /config/web.php
        //     );
        return json_encode($results);
    }
}
