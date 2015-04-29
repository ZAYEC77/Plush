<?php

namespace app\models\catalog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\orders\Order;

/**
 * OrderSearch represents the model behind the search form about `app\models\orders\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'createdAt', 'status'], 'integer'],
            [['price'], 'number'],
            [['description', 'contacts'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Order::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'userId' => $this->userId,
            'createdAt' => $this->createdAt,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'contacts', $this->contacts]);

        return $dataProvider;
    }
}
