<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%phone_number}}".
 *
 * @property int $customer_id
 * @property int $phone_type_id
 * @property string|null $phone_number
 *
 * @property Customer $customer
 * @property PhoneType $phoneType
 * @property PhoneType $phoneType0
 */
class PhoneNumber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%phone_number}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'phone_number'], 'required'],
            [['customer_id', 'phone_type_id'], 'integer'],
            [['phone_number'], 'string', 'max' => 15],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
            [['phone_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PhoneType::className(), 'targetAttribute' => ['phone_type_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('app', 'Customer ID'),
            'phone_type_id' => Yii::t('app', 'Phone Type ID'),
            'phone_number' => Yii::t('app', 'Phone Number'),
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * Gets query for [[PhoneType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneType()
    {
        return $this->hasOne(PhoneType::className(), ['id' => 'phone_type_id']);
    }

    /**
     * Gets query for [[PhoneType0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneType0()
    {
        return $this->hasOne(PhoneType::className(), ['id' => 'phone_type_id']);
    }
}
