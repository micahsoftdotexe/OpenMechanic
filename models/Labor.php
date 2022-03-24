<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%labor}}".
 *
 * @property int $id
 * @property int $workorder_id
 * @property string $description
 * @property string|null $notes
 * @property float $price
 *
 * @property Workorder $workorder
 */
class Labor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%labor}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id', 'description', 'price'], 'required'],
            [['workorder_id'], 'integer'],
            [['description', 'notes'], 'string'],
            [['price'], 'number'],
            [['workorder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Workorder::class, 'targetAttribute' => ['workorder_id' => 'id']],
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
            'description' => Yii::t('app', 'Description'),
            'notes' => Yii::t('app', 'Notes'),
            'price' => Yii::t('app', 'Price'),
        ];
    }

    /**
     * Gets query for [[Workorder]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkorder()
    {
        return $this->hasOne(Workorder::class, ['id' => 'workorder_id']);
    }
}
