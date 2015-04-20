<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\catalog\Category */

$this->title = Yii::t('catalog', 'Update Category: ') . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('catalog', 'Update');
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
