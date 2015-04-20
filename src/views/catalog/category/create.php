<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\catalog\Category */

$this->title = Yii::t('catalog', 'Create Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('catalog', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
