<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%workorder}}".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $automobile_id
 * @property string|null $date
 * @property float|null $subtotal
 * @property float|null $tax
 * @property string|null $workorder_notes
 * @property float|null $amount_paid
 * @property int|null $paid_in_full
 *
 * @property Labor[] $labors
 * @property Part[] $parts
 * @property Automobile $automobile
 * @property Customer $customer
 */
class Workorder extends \yii\db\ActiveRecord
{
    public $make;
    public $model;
    const SCENARIO_STEP1 = 'step1';
    const SCENARIO_STEP2 = 'step2';
    const SCENARIO_STEP3= 'step3';

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_STEP1] = ['customer_id', 'automobile_id'];
        return $scenarios;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%workorder}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id', 'automobile_id'], 'required'],
            [['customer_id', 'automobile_id', 'paid_in_full'], 'integer'],
            [['date'], 'safe'],
            [['subtotal', 'tax', 'amount_paid'], 'number'],
            [['workorder_notes'], 'string'],
            [['automobile_id'], 'exist', 'skipOnError' => true, 'targetClass' => Automobile::className(), 'targetAttribute' => ['automobile_id' => 'id']],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', 'Customer ID'),
            'automobile_id' => Yii::t('app', 'Automobile ID'),
            'date' => Yii::t('app', 'Date'),
            'subtotal' => Yii::t('app', 'Subtotal'),
            'tax' => Yii::t('app', 'Tax'),
            'make' => Yii::t('app', 'Make'),
            'workorder_notes' => Yii::t('app', 'Workorder Notes'),
            'amount_paid' => Yii::t('app', 'Amount Paid'),
            'paid_in_full' => Yii::t('app', 'Paid In Full'),
        ];
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
     * Gets query for [[Parts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParts()
    {
        return $this->hasMany(Part::className(), ['workorder_id' => 'id']);
    }

    /**
     * Gets query for [[Automobile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAutomobile()
    {
        return $this->hasOne(Automobile::className(), ['id' => 'automobile_id']);
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
