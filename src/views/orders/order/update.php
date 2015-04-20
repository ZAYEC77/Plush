<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\orders\Order */

$this->title = Yii::t('orders', 'Update Order: ') . '# ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('orders', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '# ' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('orders', 'Update');
?>
<div class="order-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
