<?php

namespace app\models\catalog;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProductSearch represents the model behind the search form about `app\models\catalog\Product`.
 */
class ProductSearch extends Product
{
    public $searchTitle;
    public $priceFrom;
    public $priceTo;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vendorId', 'status', 'createdAt', 'updatedAt', 'amount'], 'integer'],
            [['title', 'image', 'description', 'searchTitle', 'priceFrom', 'priceTo'], 'safe'],
            [['price'], 'number'],
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
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'vendorId' => $this->vendorId,
            'price' => $this->price,
            'amount' => $this->amount,
            'status' => $this->status,
            'createdAt' => $this->createdAt,
            'updatedAt' => $this->updatedAt,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'image', $this->image])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }

    public function clientSearch($params)
    {
        $query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $title = trim($this->searchTitle);
        $words = explode(' ', $title);

        $query->joinWith('vendor');
        $query->joinWith('categories');

        foreach ($words as $word) {
            $query->orFilterWhere(['like', 'vendor.title', $word]);
            $query->orFilterWhere(['like', 'category.title', $word]);
            $query->orFilterWhere(['like', 'product.title', $word]);
        }
        $query->andFilterWhere([
            'vendorId' => $this->vendorId,
        ]);

        $priceFrom = floatval($this->priceFrom);
        if ($priceFrom) {
            $query->andWhere(['>=', 'price', $priceFrom]);
        }
        $priceTo = floatval($this->priceTo);
        if ($priceTo) {
            $query->andWhere(['<=', 'price', $priceTo]);
        }
        return $dataProvider;
    }
}
