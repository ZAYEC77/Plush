<?php

use app\components\Helper;
use yii\helpers\Html;
use yii\grid\GridView;
use app\models\catalog\Vendor;
use app\models\catalog\Product;
use rmrevin\yii\fontawesome\FA;

/* @var $this yii\web\View */
/* @var $searchModel app\models\catalog\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('catalog', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(FA::icon('plus-circle') . ' ' . Yii::t('catalog', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'price:money',
            [
                'filter' => false,
                'format' => 'raw',
                'attribute' => 'image',
                'value' => function (Product $model) {
                    return Html::img($model->getPicture(), ['class' => 'admin-image']);
                }
            ],
            [
                'filter' => Vendor::getDropDownArray('id', 'title'),
                'attribute' => 'vendorId',
                'value' => 'vendor.title',
            ],
            [
                'format' => 'status',
                'filter' => Helper::getStatuses(),
                'attribute' => 'status',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
