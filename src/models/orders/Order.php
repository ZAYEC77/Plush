<?php

namespace app\models\orders;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\ActiveRecord;
use yz\shoppingcart\ShoppingCart;

/**
 * This is the model class for table "{{%order}}".
 *
 * @property integer $id
 * @property string $price
 * @property integer $userId
 * @property string $description
 * @property string $contacts
 * @property integer $createdAt
 * @property integer $status
 *
 * @property OrderItem[] $orderItems
 */
class Order extends ActiveRecord
{
    const STATUS_NEW = 1;
    const STATUS_IN_PROGRESS = 2;
    const STATUS_DONE = 3;

    /** @var OrderItem[] */
    protected $_items = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['userId', 'createdAt', 'status'], 'integer'],
            [['description', 'contacts'], 'string'],
            [['contacts', 'status'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('orders', 'ID'),
            'price' => Yii::t('orders', 'Price'),
            'userId' => Yii::t('orders', 'User ID'),
            'description' => Yii::t('orders', 'Notes'),
            'status' => Yii::t('orders', 'Status'),
            'contacts' => Yii::t('orders', 'Contacts'),
            'createdAt' => Yii::t('orders', 'Created At'),
        ];
    }

    /**
     * Create new instance of model and set price from cart
     * @return Order
     */
    public static function createFromCart()
    {
        $cart = new ShoppingCart();
        $model = new self(['status' => self::STATUS_NEW]);
        $model->price = $cart->getCost();
        foreach ($cart->getPositions() as $item) {
            $orderItem = new OrderItem();
            $orderItem->productId = $item->id;
            $orderItem->amount = $item->quantity;
            $orderItem->price = $item->getPrice();
            $model->addItem($orderItem);
        }
        return $model;
    }

    /**
     * Save record with related items
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $result = parent::save($runValidation, $attributeNames);
        foreach ($this->_items as $item) {
            $this->link('orderItems', $item);
            $result = $result && $item->save($runValidation);
        }
        return $result;
    }

    /**
     * @param OrderItem $item
     */
    public function addItem(OrderItem $item)
    {
        $this->_items[] = $item;
    }

    /**
     * Set user id if user authorized
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!Yii::$app->user->isGuest) {
            $this->userId = Yii::$app->user->id;
        }
        if (!$insert) {
            $this->price = 0;
            foreach ($this->orderItems as $item) {
                $this->price += $item->cost;
            }
        }
        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => false,
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderItems()
    {
        return $this->hasMany(OrderItem::className(), ['orderId' => 'id']);
    }

    /**
     * @return ActiveDataProvider
     */
    public function getItemsProvider()
    {
        if ($this->isNewRecord) {
            return new ArrayDataProvider(['models' => $this->_items]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $this->getOrderItems(),
        ]);
        return $dataProvider;
    }

    /**
     * Remove related records
     * @throws \Exception
     */
    public function afterDelete()
    {
        foreach ($this->orderItems as $item) {
            $item->delete();
        }
        parent::afterDelete();
    }

    /**
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_NEW => Yii::t('orders', 'New'),
            self::STATUS_IN_PROGRESS => Yii::t('orders', 'In Progress'),
            self::STATUS_DONE => Yii::t('orders', 'Done'),
        ];
    }
}
