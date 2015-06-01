<?php
use app\models\catalog\Vendor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/** @var $this \yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $model \app\models\catalog\ProductSearch */
$this->title = Yii::t('app', 'Search results');
?>
<div class="site-search">
    <div class="row">
        <div class="search-form">
            <h1><?= $this->title ?></h1>
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['/site/search']]) ?>
            <?= Html::activeTextInput($model, 'searchTitle', ['placeholder' => Yii::t('app', 'Enter name of toy')]) ?>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <button type="button" class="btn btn-success" data-toggle="collapse"
                    data-target="#search-details"><?= Yii::t('app', 'Details') ?></button>
            <div class="collapse" id="search-details">
                <?= Html::activeInput('number', $model, 'priceFrom', ['placeholder' => Yii::t('app', 'Price from')]) ?>
                <?= Html::activeInput('number', $model, 'priceTo', ['placeholder' => Yii::t('app', 'Price to')]) ?>
                <?= Html::activeDropDownList($model, 'vendorId', Vendor::getDropDownArray('id', 'title'), ['prompt' => Yii::t('app', 'Select vendor')]) ?>
            </div>
            <?php $form->end() ?>
        </div>
    </div>
    <?= ListView::widget([
        'itemView' => '_index-product',
        'dataProvider' => $dataProvider,
        'options' => ['class' => 'list-view row'],
    ]) ?>
</div>