<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%part}}".
 *
 * @property int $id
 * @property int $order_id
 * @property float $price
 * @property float $margin
 * @property string $description
 * @property string $part_number
 * @property float $quantity
 * @property int $quantity_type_id
 *
 * @property Order $order
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
            [['price', 'margin', 'description', 'part_number', 'quantity', 'order_id'], 'required'],
            [['order_id','quantity_type_id'], 'integer'],
            [['price', 'margin', 'quantity'], 'number'],
            [['description'], 'string'],
            [['part_number'], 'string', 'max' => 100],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Order::class, 'targetAttribute' => ['order_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'order_id' => Yii::t('app', 'Order ID'),
            'price' => Yii::t('app', 'Price'),
            'margin' => Yii::t('app', 'Margin'),
            'description' => Yii::t('app', 'Description'),
            'part_number' => Yii::t('app', 'Part Number'),
        ];
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::class, ['id' => 'order_id']);
    }
}
