<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\catalog\Vendor */

$this->title = Yii::t('catalog', 'Update Vendor: ') . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('catalog', 'Update');
?>
<div class="vendor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
