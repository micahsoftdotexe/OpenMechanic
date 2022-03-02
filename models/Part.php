<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%part}}".
 *
 * @property int $id
 * @property int $workorder_id
 * @property float $price
 * @property float $margin
 * @property string $description
 * @property string $part_number
 * @property float $quantity
 * @property int $quantity_type_id
 *
 * @property Workorder $workorder
 */
class Part extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%part}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'margin', 'description', 'part_number', 'quantity'], 'required'],
            [['workorder_id','quantity_type_id'], 'integer'],
            [['price', 'margin', 'quantity'], 'number'],
            [['description'], 'string'],
            [['part_number'], 'string', 'max' => 100],
            [['workorder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workorder::className(), 'targetAttribute' => ['workorder_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'workorder_id' => Yii::t('app', 'Workorder ID'),
            'price' => Yii::t('app', 'Price'),
            'margin' => Yii::t('app', 'Margin'),
            'description' => Yii::t('app', 'Description'),
            'part_number' => Yii::t('app', 'Part Number'),
        ];
    }

    /**
     * Gets query for [[Workorder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkorder()
    {
        return $this->hasOne(Workorder::className(), ['id' => 'workorder_id']);
    }
}
