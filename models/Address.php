<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%address}}".
 *
 * @property int $customer_id
 * @property int $address_type_id
 * @property string $street_address_1
 * @property string $street_address_2
 * @property string $city
 * @property string $zip
 * @property string $state
 *
 * @property AddressType $addressType
 * @property Customer $customer
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'address_type_id', 'street_address_1', 'street_address_2', 'city', 'zip', 'state'], 'required'],
            [['customer_id', 'address_type_id'], 'integer'],
            [['street_address_1', 'street_address_2'], 'string', 'max' => 250],
            [['city'], 'string', 'max' => 100],
            [['zip'], 'string', 'max' => 10],
            [['state'], 'string', 'max' => 2],
            [['address_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => AddressType::className(), 'targetAttribute' => ['address_type_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => Yii::t('app', 'Customer ID'),
            'address_type_id' => Yii::t('app', 'Address Type ID'),
            'street_address_1' => Yii::t('app', 'Street Address 1'),
            'street_address_2' => Yii::t('app', 'Street Address 2'),
            'city' => Yii::t('app', 'City'),
            'zip' => Yii::t('app', 'Zip'),
            'state' => Yii::t('app', 'State'),
        ];
    }

    /**
     * Gets query for [[AddressType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddressType()
    {
        return $this->hasOne(AddressType::className(), ['id' => 'address_type_id']);
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
}
