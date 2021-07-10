<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%customer}}".
 *
 * @property int $id
 * @property string|null $firstName
 * @property string|null $lastName
 *
 * @property Address[] $addresses
 * @property Labor[] $labors
 * @property Owns[] $owns
 * @property PhoneNumber[] $phoneNumbers
 * @property Workorder[] $workorders
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['firstName', 'lastName', 'fullName'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'firstName' => Yii::t('app', 'First Name'),
            'lastName' => Yii::t('app', 'Last Name'),
            'fullName' => Yii::t('app', 'Full Name'),
        ];
    }

    /**
     * Gets query for [[Addresses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAddresses()
    {
        return $this->hasMany(Address::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Labors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLabors()
    {
        return $this->hasMany(Labor::className(), ['workorder_id' => 'id']);
    }

    /**
     * Gets query for [[Owns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwns()
    {
        return $this->hasMany(Owns::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[PhoneNumbers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneNumbers()
    {
        return $this->hasMany(PhoneNumber::className(), ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Workorders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkorders()
    {
        return $this->hasMany(Workorder::className(), ['customer_id' => 'id']);
    }

    public function getAutomobiles()
    {
        return $this->hasMany(Automobile::class,['id' => 'automobile_id'])
            ->viaTable('owns',['customer_id'=>'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public static function getIds()
    {
        $models = self::find()->orderBy(['id'=> SORT_ASC])->all();
        return \yii\helpers\ArrayHelper::map($models, 'id', 'fullName');
    }
}
