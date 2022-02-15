<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Workorder;

/**
 * WorkorderSearch represents the model behind the search form of `app\models\Workorder`.
 */
class WorkorderSearch extends Workorder
{
    public $fullName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'automobile_id', 'paid_in_full'], 'integer'],
            [['date', 'workorder_notes', 'customer_id','make','model', 'fullName'], 'safe'],
            [['subtotal', 'tax', 'amount_paid'], 'number'],
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
        $query = Workorder::find();
        $query->leftJoin('customer', 'customer.id=workorder.customer_id');
        $query->leftJoin('automobile', 'automobile.id=workorder.automobile_id');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'fullName' => [
                    'asc' => ['customer.firstName' => SORT_ASC, 'customer.lastName' => SORT_ASC],
                    'desc' => ['customer.firstName' => SORT_DESC, 'customer.lastName' => SORT_DESC],
                    'label' => 'Full Name',
                    'default' => SORT_ASC
                ],
            ]
        ]);
        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            //'customer_id' => $this->customer_id,
            //'fullName' => $this->fullName,
            'automobile_id' => $this->automobile_id,
            'date' => $this->date,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
            'amount_paid' => $this->amount_paid,
            'paid_in_full' => $this->paid_in_full,
        ]);

        $query->andFilterWhere(['like', 'workorder_notes', $this->workorder_notes])
            //->andFilterWhere(['like', 'customer.fullName', $this->customer_id])
            ->andFilterWhere(['like', 'automobile.make', $this->make])
            ->andFilterWhere(['like', 'automobile.model', $this->model]);
        \Yii::debug($this->fullName, 'dev');
        $query->andWhere('customer.firstName LIKE "%' . $this->fullName . '%" ' .
        'OR customer.lastName LIKE "%' . $this->fullName . '%"'
        );
        
        return $dataProvider;
    }
}
