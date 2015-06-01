<?php

namespace app\models\catalog;

use app\components\PictureTrait;
use app\components\ProductQuery;
use voskobovich\behaviors\ManyToManyBehavior;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "{{%product}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property integer $vendorId
 * @property string $price
 * @property integer $amount
 * @property integer $status
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Vendor $vendor
 * @property Category[] $categories
 * @property Category[] $categoriesList
 */
class Product extends ActiveRecord implements CartPositionInterface
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 1;

    use PictureTrait;
    use CartPositionTrait;

    public function getPrice()
    {
        return $this->price;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ProductQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return new ProductQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['vendorId', 'status'], 'integer'],
            [['amount'], 'integer', 'min' => 0],
            [['price'], 'number'],
            [['price', 'title', 'amount'], 'required'],
            [['createdAt', 'updatedAt', 'categoriesList'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('catalog', 'ID'),
            'title' => Yii::t('catalog', 'Title'),
            'image' => Yii::t('catalog', 'Image'),
            'picture' => Yii::t('catalog', 'Image'),
            'description' => Yii::t('catalog', 'Description'),
            'categoriesList' => Yii::t('catalog', 'Categories'),
            'vendorId' => Yii::t('catalog', 'Vendor'),
            'price' => Yii::t('catalog', 'Price'),
            'amount' => Yii::t('catalog', 'Amount'),
            'status' => Yii::t('catalog', 'Status'),
            'createdAt' => Yii::t('catalog', 'Created At'),
            'updatedAt' => Yii::t('catalog', 'Updated At'),
        ];
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'createdAt',
                'updatedAtAttribute' => 'updatedAt',
            ],
            [
                'class' => ManyToManyBehavior::className(),
                'relations' => [
                    'categoriesList' => 'categories',
                ],
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVendor()
    {
        return $this->hasOne(Vendor::className(), ['id' => 'vendorId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['id' => 'categoryId'])
            ->viaTable('{{%product_has_category}}', ['productId' => 'id']);
    }
}
