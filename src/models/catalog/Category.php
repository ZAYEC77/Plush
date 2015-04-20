<?php

namespace app\models\catalog;

use app\components\PictureTrait;
use Yii;
use nullref\useful\DropDownTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property integer $parentId
 * @property integer $createdAt
 * @property integer $updatedAt
 *
 * @property Product[] $products
 * @property Category[] $categories
 * @property Category $parent
 * @property Category[] $parents
 */
class Category extends ActiveRecord
{
    use DropDownTrait;
    use PictureTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentId'], 'default', 'value' => 0],
            [['description'], 'string'],
            [['parentId', 'createdAt', 'updatedAt'], 'integer'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
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
                'updatedAtAttribute' => 'updatedAt',
            ],
        ]);
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
            'parentId' => Yii::t('catalog', 'Parent Category'),
            'createdAt' => Yii::t('catalog', 'Created At'),
            'updatedAt' => Yii::t('catalog', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['id' => 'productId'])
            ->viaTable('{{%product_has_category}}', ['categoryId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(self::className(), ['parentId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parentId']);
    }

    /**
     * @return Category[]
     */
    public function getParents()
    {
        $result = [];
        if ($this->parent !== null) {
            $result[] = $this->parent;
            $parents = $this->parent->parents;
            if (!empty($parents)) {
                $result[] = $this->parents;
            }
        }
        return $result;
    }

    public static function getNestedList($checked = [])
    {
        $list = self::find()->orderBy('parentId')->asArray()->all();
        foreach ($checked as $key => $id) {
            for ($i = 0; $i < count($list); $i++) {
                if ($list[$i]['id'] == $id) {
                    $list[$i]['selected'] = true;
                    break;
                }
            }
        }
        $getChildren = function ($id) use ($list, &$getChildren) {
            $result = [];
            for ($i = 0; $i < count($list); $i++) {
                $item = $list[$i];
                if ($item['parentId'] == $id) {
                    $r = ['title' => $item['title'], 'key' => $item['id'], 'selected' => isset($item['selected'])];
                    $c = $getChildren($item['id']);
                    if (!empty($c)) {
                        $r['folder'] = true;
                        $r['children'] = $c;
                    }
                    $result[] = $r;
                    unset($list[$i]);
                }
            }
            return $result;
        };
        return $getChildren(0);
    }
}
