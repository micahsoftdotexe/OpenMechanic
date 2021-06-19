<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%address_type}}".
 *
 * @property int $id
 * @property string $address_description
 *
 * @property Address[] $addresses
 */
class AddressType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_description'], 'required'],
            [['address_description'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address_description' => Yii::t('app', 'Address Description'),
        ];
    }

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['address_type_id' => 'id']);
    }
}
