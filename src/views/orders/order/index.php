<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\orders\Order;

/* @var $this yii\web\View */
/* @var $searchModel app\models\catalog\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('orders', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('orders', 'Create Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['label' => '#', 'attribute' => 'id'],
            'price:money',
            'createdAt:datetime',
            [
                'filter' => Order::getStatuses(),
                'format' => 'orderStatus',
                'attribute' => 'status',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
