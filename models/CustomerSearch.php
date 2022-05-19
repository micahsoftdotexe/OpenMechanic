<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Customer;

/**
 * CustomerSearch represents the model behind the search form of `app\models\Customer`.
 */
class CustomerSearch extends Customer
{
    public $fullName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
            [['fullName', 'phone_number_1', 'phone_number_2'], 'safe'],
            [['phone_number_1', 'phone_number_2'],  \borales\extensions\phoneInput\PhoneInputValidator::class],
            [['phone_number_1', 'phone_number_2'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Customer::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $dataProvider->setSort([ //merge array
            'attributes' => [
                //'id',
                'fullName' => [
                    'asc' => ['customer.first_name' => SORT_ASC, 'customer.last_name' => SORT_ASC],
                    'desc' => ['customer.first_name' => SORT_DESC, 'customer.last_name' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
                'date',
            ]
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        // $query->andFilterWhere([
        //     'id' => $this->id,
        // ]);

        $query->andWhere('first_name LIKE "%' . $this->fullName . '%" ' .
        'OR last_name LIKE "%' . $this->fullName . '%"'. 'OR Concat(customer.first_name, " ", customer.last_name) LIKE "%' . $this->fullName . '%"' );

        // $query->andFilterWhere(['like', 'firstName', $this->firstName])
        //     ->andFilterWhere(['like', 'lastName', $this->lastName]);

        return $dataProvider;
    }
}
