<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\catalog\Vendor;
use app\components\Helper;
use \app\models\catalog\Category;
use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use wbraganca\fancytree\FancytreeWidget;
use yii\web\JsExpression;

rmrevin\yii\fontawesome\AssetBundle::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\catalog\Product */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(<<<JS
var tree = jQuery("#fancyree_categoriesTree");
plush.initTree = function () {
    tree.fancytree("getTree").generateFormElements("Product[categoriesList][]");
};
plush.selectTreeNode = plush.initTree;
JS
);
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget(InputFile::className(), Helper::getInputFileOptions()) ?>
    <?php if (!$model->isNewRecord): ?>
        <?= Html::a(Html::img($model->getPicture()), $model->getPicture(), ['rel' => 'fancybox']); ?>
    <?php endif ?>

    <?= $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions(['elfinder',], [
            'preset' => 'full',
            'height' => 200,
        ]),
    ]) ?>

    <?= $form->field($model, 'vendorId')->dropDownList(Vendor::getDropDownArray('id', 'title')) ?>


    <?= FancytreeWidget::widget([
        'id' => 'categoriesTree',
        'options' => [
            'source' => Category::getNestedList($model->categoriesList),
            'checkbox' => true,
            'titlesTabbable' => true,
            'clickFolderMode' => 3,
            'init' => new JsExpression('plush.initTree'),
            'select' => new JsExpression('plush.selectTreeNode'),
            'extensions' => ["glyph", "edit", "wide"],
            'glyph' => [
                'map' => [

                    'doc' => "fa fa-file-o",
                    'docOpen' => "fa fa-file",
                    'checkbox' => "fa fa-square-o",
                    'checkboxSelected' => "fa fa-check-square-o",
                    'checkboxUnknown' => "fa fa-share",
                    'error' => "fa fa-warning-sign",
                    'expanderClosed' => "fa fa-plus-square-o",
                    'expanderLazy' => "fa fa-spinner fa-spin",
                    'expanderOpen' => "fa fa-minus-square-o",
                    'folder' => "fa fa-folder-o",
                    'folderOpen' => "fa fa-folder-open-o",
                    'loading' => "fa fa-refresh",
                ]
            ],
        ]
    ]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(Helper::getStatuses()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('catalog', 'Create') : Yii::t('catalog', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
