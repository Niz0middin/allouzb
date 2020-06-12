<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cart;

/**
 * CartSearch represents the model behind the search form of `app\models\Cart`.
 */
class ProductStatsSearch extends Cart
{
    public $from;
    public $to;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'order_id', 'count'], 'integer'],
            [['cost'], 'number'],
            [['created_at', 'updated_at', 'from', 'to'], 'safe'],
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
        $query = Cart::find();

        $query->select(['product_id', 'sum(count) as count', 'sum(cost) as cost']);

        $query->groupBy(['product_id']);

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
//            'id' => $this->id,
            'product_id' => $this->product_id,
//            'order_id' => $this->order_id,
//            'cost' => $this->cost,
//            'count' => $this->count,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
        ]);

        if(!empty($this->from)){
            $query->andFilterWhere(['between', 'created_at', strtotime($this->from),strtotime($this->to)]);
        }

        return $dataProvider;
    }
}
