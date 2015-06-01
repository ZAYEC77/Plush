<?php

namespace app\models\catalog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form about `app\models\catalog\Product`.
 */
class ProductClientSearch extends Product
{
    public $name = '';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vendorId', 'status', 'createdAt', 'updatedAt', 'amount'], 'integer'],
            [['title', 'image', 'description', 'name'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        $query->joinWith('vendor');
        $query->joinWith('categories');

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'title', $this->name])
            ->andFilterWhere(['like', 'title', $this->name])
            ->andFilterWhere(['like', 'vendor.title', $this->name])
            ->andFilterWhere(['like', 'categories.title', $this->name]);

        return $dataProvider;
    }
}
