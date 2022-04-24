<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%quantity_type}}".
 *
 * @property int $id
 * @property string $description
 */
class QuantityType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%quantity_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'required'],
            [['description'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Returns an array that maps the quantity type id to the quantity type description.
     * @return array
    */

    public static function getIds()
    {
        $models = self::find()->orderBy(['id'=>SORT_ASC])->all();
        return \yii\helpers\ArrayHelper::map($models, 'id', 'description');
    }
}
