<?php

namespace app\models\catalog;

use app\components\PictureTrait;
use Yii;
use nullref\useful\DropDownTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%vendor}}".
 *
 * @property integer $id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property integer $createdAt
 * @property integer $updatedAt
 */
class Vendor extends ActiveRecord
{
    use DropDownTrait;
    use PictureTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vendor}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description'], 'string'],
            [['createdAt', 'updatedAt'], 'safe'],
            [['title', 'image'], 'string', 'max' => 255]
        ];
    }

    /**
     * @return array
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
            'createdAt' => Yii::t('catalog', 'Created At'),
            'updatedAt' => Yii::t('catalog', 'Updated At'),
        ];
    }
}
