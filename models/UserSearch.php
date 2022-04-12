<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * OrderSearch represents the model behind the search form of `app\models\Order`.
 */
class UserSearch extends User
{
    public $fullName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'fullName'], 'safe'],
            ['status', 'integer'],
        ];
    }

    public function search($params)
    {
        $query = User::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // $this->load($params);
        $dataProvider->setSort([ //merge array
            'attributes' => [
                'username',
                'fullName' => [
                    'asc' => ['customer.first_name' => SORT_ASC, 'customer.last_name' => SORT_ASC],
                    'desc' => ['customer.first_name' => SORT_DESC, 'customer.last_name' => SORT_DESC],
                ],
                'status',
            ],
        ]);
        if (!($this->load($params) && $this->validate())) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'status' => $this->status,
            'username' => $this->username,
        ]);
        $query->andWhere('first_name LIKE "%' . $this->fullName . '%" ' .
        'OR last_name LIKE "%' . $this->fullName . '%"'
        );

        return $dataProvider;
    }
}
