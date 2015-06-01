<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\jui\DatePicker;

/** @var $this \yii\web\View */
/** @var $data array */
/** @var $model \app\models\Statistic */

$this->title = Yii::t('app', 'Statistic');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statistic-index">
    <h1><?= $this->title ?></h1>

    <div class="well">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'layout' => 'inline',
        ]) ?>
        <?= $form->errorSummary($model) ?>
        <div class="clearfix"></div>
        <div class="form-group">
            <?= Yii::t('app', 'Date from') ?>:
            <?= $form->field($model, 'dateFrom')->widget(DatePicker::classname(), [
                'language' => 'uk',
                'dateFormat' => 'dd.M.yyyy',
            ]) ?>
            <?= Yii::t('app', 'Date to') ?>:
            <?= $form->field($model, 'dateTo')->widget(DatePicker::classname(), [
                'language' => 'uk',
                'dateFormat' => 'dd.M.yyyy',
            ]) ?>
            <?= Html::submitButton(Yii::t('app', 'Show'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php $form->end() ?>
    </div>
    <div class="clearfix"></div>
    <?php if (count($data)): ?>
        <table class="table table-bordered table-striped">
            <tr>
                <td><?= Yii::t('app', 'Product') ?></td>
                <td><?= Yii::t('app', 'Amount') ?></td>
                <td><?= Yii::t('app', 'Cost') ?></td>
            </tr>
            <?php foreach ($data as $item): ?>
                <tr>
                    <td><?= $item['product'] ?></td>
                    <td><?= Yii::$app->formatter->asQuantity($item['amount']) ?></td>
                    <td><?= Yii::$app->formatter->asMoney($item['cost']) ?></td>
                </tr>
            <?php endforeach ?>
        </table>
    <?php else: ?>
        <?= Yii::t('app', 'Nothing found') ?>
    <?php endif ?>
</div>