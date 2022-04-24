<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stage".
 *
 * @property int $id
 * @property string|null $title
 *
 * @property Order[] $orders
*/
class Stage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stage';
    }

    /**
     * {@inheritdoc}
    */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 15],
        ];
    }

    /**
     * {@inheritdoc}
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['stage_id' => 'id']);
    }
}
