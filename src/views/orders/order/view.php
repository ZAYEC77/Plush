<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\orders\Order */

$this->title = '# ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('orders', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('orders', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('orders', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('orders', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'price:money',
            'description:ntext',
            'createdAt:datetime',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $model->getItemsProvider(),
        'columns' => [
            'product.title',
            'price',
            'amount',
            [
                'class' => 'yii\grid\ActionColumn',
                'controller' => 'orders/order-item',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>

</div>
