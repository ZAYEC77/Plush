<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $model \app\models\catalog\ProductSearch */
$this->title = Yii::$app->name;
?>
<div class="site-index">

    <div class="jumbotron">
        <span class="lead">Ласкаво просимо до магазину м’яких іграшок</span>

        <h1>Plush!</h1>

        <div class="search-form">
            <?php $form = ActiveForm::begin(['method' => 'get', 'action' => ['/site/search']]) ?>
            <?= Html::activeTextInput($model, 'searchTitle', ['placeholder' => Yii::t('app', 'Enter name of toy')]) ?>
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            <?php $form->end() ?>
        </div>
    </div>

    <div class="body-content">

        <div>
            <?= ListView::widget([
                'itemView' => '_index-product',
                'dataProvider' => $dataProvider,
                'layout' => "{items}",
                'options' => ['class' => 'list-view row'],
            ]) ?>
        </div>

    </div>
</div>
