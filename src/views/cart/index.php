<?php

use yii\helpers\Html;
use yii\grid\GridView;
use rmrevin\yii\fontawesome\FA;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cart');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="cart-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php \yii\widgets\Pjax::begin() ?>
    <?= GridView::widget([
        'emptyText' => Yii::t('cart', 'Cart is empty'),
        'layout' => '{items}',
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            ['value' => 'title', 'label' => Yii::t('cart', 'Product')],
            ['format' => 'quantity', 'value' => 'quantity', 'label' => Yii::t('cart', 'Amount')],
            ['format' => 'money', 'value' => 'price', 'label' => Yii::t('cart', 'Price')],
            ['format' => 'money', 'value' => 'cost', 'label' => Yii::t('cart', 'Cost')],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add} {sub} {delete}',
                'buttons' => [
                    'add' => function ($url) {
                        return Html::a(FA::icon('plus'), $url, [
                            'title' => Yii::t('cart', 'Add'),
                            'data-pjax' => '0',
                        ]);
                    },
                    'sub' => function ($url) {
                        return Html::a(FA::icon('minus'), $url, [
                            'title' => Yii::t('cart', 'Sub'),
                            'data-pjax' => '0',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end() ?>
    <?php if ($dataProvider->count): ?>
        <div class="well">
            <?= Html::a(Yii::t('cart', 'Make Order'), ['/orders/order/create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('cart', 'Clear Cart'), ['/cart/clear'], ['class' => 'btn btn-danger']) ?>
        </div>
    <?php endif ?>
</div>
