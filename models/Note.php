<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property int $id
 * @property int $workorder_id
 * @property string|null $text
 *
 * @property Workorder $workorder
 */
class Note extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['workorder_id'], 'required'],
            [['workorder_id'], 'integer'],
            [['text'], 'string'],
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
            'text' => Yii::t('app', 'Text'),
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
