<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\catalog\Category;
use app\components\Helper;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;

/* @var $this yii\web\View */
/* @var $model app\models\catalog\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(InputFile::className(), Helper::getInputFileOptions()) ?>
    <?php if (!$model->isNewRecord): ?>
        <?= Html::a(Html::img($model->getPicture()), $model->getPicture(), ['rel' => 'fancybox']); ?>
    <?php endif ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder',], [
            'preset' => 'full',
        ]),
    ]) ?>

    <?= $form->field($model, 'parentId')->dropDownList(Category::getDropDownArray('id', 'title', ['not in', 'id', isset($model->id) ? $model->id : 0]), ['prompt' => Yii::t('app', 'N/A')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('catalog', 'Create') : Yii::t('catalog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
