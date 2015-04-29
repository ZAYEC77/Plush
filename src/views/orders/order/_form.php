<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use app\models\orders\Order;

/* @var $this yii\web\View */
/* @var $model app\models\orders\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'price')->textInput(['readonly' => true, 'maxlength' => true]) ?>

    <?php if (!$model->isNewRecord): ?>
        <?= $form->field($model, 'status')->dropDownList(Order::getStatuses()) ?>
    <?php endif ?>

    <?= $form->field($model, 'contacts')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= GridView::widget([
        'layout' => '{items}',
        'dataProvider' => $model->getItemsProvider(),
        'columns' => [
            'product.title',
            'price:money',
            'amount:quantity',
            'cost:money',
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('orders', 'Create') : Yii::t('orders', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
