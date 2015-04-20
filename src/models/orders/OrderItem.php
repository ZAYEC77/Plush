<?php

namespace app\models\orders;

use app\models\catalog\Product;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%order_item}}".
 *
 * @property integer $id
 * @property integer $amount
 * @property integer $orderId
 * @property integer $productId
 * @property string $price
 *
 * @property Order $order
 * @property Product $product
 * @property float $cost
 */
class OrderItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'orderId', 'productId'], 'integer'],
            [['productId'], 'required'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('orders', 'ID'),
            'amount' => Yii::t('orders', 'Amount'),
            'cost' => Yii::t('orders', 'Cost'),
            'orderId' => Yii::t('orders', 'Order ID'),
            'productId' => Yii::t('orders', 'Product ID'),
            'price' => Yii::t('orders', 'Price'),
        ];
    }

    /**
     * @return string
     */
    public function getCost()
    {
        return $this->price * $this->amount;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'orderId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'productId']);
    }
}
