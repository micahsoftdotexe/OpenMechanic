<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%owns}}".
 *
 * @property int $customer_id
 * @property int $automobile_id
 *
 * @property Automobile $automobile
 * @property Customer $customer
 */
class Owns extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%owns}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'automobile_id'], 'required'],
            [['customer_id', 'automobile_id'], 'integer'],
            [['automobile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Automobile::class, 'targetAttribute' => ['automobile_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('app', 'Customer ID'),
            'automobile_id' => Yii::t('app', 'Automobile ID'),
        ];
    }

    /**
     * Gets query for [[Automobile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutomobile()
    {
        return $this->hasOne(Automobile::class, ['id' => 'automobile_id']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['id' => 'customer_id']);
    }
}
