<?php

namespace app\models;

use borales\extensions\phoneInput\PhoneInputValidator;

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

    public const STATES = [
        "AL"=>"ALABAMA",
        "AK"=>"ALASKA",
        "AZ"=>"ARIZONA",
        "AR"=>"ARKANSAS",
        "CA"=>"CALIFORNIA",
        "CO"=>"COLORADO",
        "CT"=>"CONNECTICUT",
        "DE"=>"DELAWARE",
        "DC"=>"DISTRICT OF COLUMBIA",
        "FL"=>"FLORIDA",
        "GA"=>"GEORGIA",
        "HI"=>"HAWAII",
        "ID"=>"IDAHO",
        "IL"=>"ILLINOIS",
        "IN"=>"INDIANA",
        "IA"=>"IOWA",
        "KS"=>"KANSAS",
        "KY"=>"KENTUCKY",
        "LA"=>"LOUISIANA",
        "ME"=>"MAINE",
        "MD"=>"MARYLAND",
        "MA"=>"MASSACHUSETTS",
        "MI"=>"MICHIGAN",
        "MN"=>"MINNESOTA",
        "MS"=>"MISSISSIPPI",
        "MO"=>"MISSOURI",
        "MT"=>"MONTANA",
        "NE"=>"NEBRASKA",
        "NV"=>"NEVADA",
        "NH"=>"NEW HAMPSHIRE",
        "NJ"=>"NEW JERSEY",
        "NM"=>"NEW MEXICO",
        "NY"=>"NEW YORK",
        "NC"=>"NORTH CAROLINA",
        "ND"=>"NORTH DAKOTA",
        "OH"=>"OHIO",
        "OK"=>"OKLAHOMA",
        "OR"=>"OREGON",
        "PA"=>"PENNSYLVANIA",
        "RI"=>"RHODE ISLAND",
        "SC"=>"SOUTH CAROLINA",
        "SD"=>"SOUTH DAKOTA",
        "TN"=>"TENNESSEE",
        "TX"=>"TEXAS",
        "UT"=>"UTAH",
        "VT"=>"VERMONT",
        "VA"=>"VIRGINIA",
        "VI"=>"VIRGIN ISLANDS",
        "WA"=>"WASHINGTON",
        "WV"=>"WEST VIRGINIA",
        "WI"=>"WISCONSIN",
        "WY"=>"WYOMING" ,
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name'], 'string', 'max' => 50],
            ['street_address', 'string', 'max' => 256],
            ['city', 'string', 'max' => 128],
            ['state', 'string', 'max' => 2],
            ['state', 'in', 'range' => array_keys(self::STATES)],
            ['zip', 'string', 'max' => 10],
            ['zip', 'match', 'pattern' => '/(^\d{5}$)|(^\d{9}$)|(^\d{5}-\d{4}$)/'],
            [['phone_number_1', 'phone_number_2'], 'string', 'max' => 15],
            [['phone_number_1', 'phone_number_2'], PhoneInputValidator::class],
            [['first_name', 'last_name'], 'required']
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
     * Gets query for [[Labors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLabors()
    {
        return $this->hasMany(Labor::class, ['workorder_id' => 'id']);
    }

    /**
     * Gets query for [[Owns]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOwns()
    {
        return $this->hasMany(Owns::class, ['customer_id' => 'id']);
    }

    /**
     * Gets query for [[Workorders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getWorkorders()
    {
        return $this->hasMany(Workorder::class, ['customer_id' => 'id']);
    }

    public function getAutomobiles()
    {
        return $this->hasMany(Automobile::class, ['id' => 'automobile_id'])
            ->viaTable('owns', ['customer_id'=>'id']);
    }

    public function getFullName()
    {
        //Yii::debug($this->firstName . ' ' . $this->lastName, 'dev');
        return $this->first_name.' '.$this->last_name;
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
