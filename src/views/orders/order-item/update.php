<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\orders\OrderItem */

$this->title = Yii::t('orders', 'Update Order Item: ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('orders', 'Order Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('orders', 'Update');
?>
<div class="order-item-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
