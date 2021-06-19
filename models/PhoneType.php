<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%phone_type}}".
 *
 * @property int $id
 * @property string|null $description
 *
 * @property PhoneNumber[] $phoneNumbers
 * @property PhoneNumber $id0
 */
class PhoneType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%phone_type}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description'], 'string', 'max' => 20],
            [['id'], 'exist', 'skipOnError' => true, 'targetClass' => PhoneNumber::className(), 'targetAttribute' => ['id' => 'phone_type_id']],
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
     * Gets query for [[PhoneNumbers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhoneNumbers()
    {
        return $this->hasMany(PhoneNumber::className(), ['phone_type_id' => 'id']);
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(PhoneNumber::className(), ['phone_type_id' => 'id']);
    }
}
