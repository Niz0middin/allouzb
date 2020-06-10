<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Orders;

/**
 * OrdersSearch represents the model behind the search form of `app\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'count', 'status'], 'integer'],
            [['order_key', 'location', 'created_at', 'updated_at', 'tel', 'time'], 'safe'],
            [['cost'], 'number'],
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
        $query = Orders::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'client_id' => $this->client_id,
            'cost' => $this->cost,
            'count' => $this->count,
            'status' => $this->status,
            'time' => $this->time,
            'tel' => $this->tel,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
        ]);

        if(!empty($this->created_at)){
            $query->andFilterWhere(['between', 'created_at', strtotime($this->created_at),strtotime($this->created_at)+86399]);
        }

        $query->andFilterWhere(['like', 'order_key', $this->order_key])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
