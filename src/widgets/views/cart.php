<?php

use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;

/**
 * @var \yii\web\View $this
 * @var integer $count
 * @var integer $cost
 *
 */
$amount = '(' . Html::tag('span', Yii::$app->formatter->asDecimal($cost), ['class' => 'cost']) . ' ' . Yii::t('app', 'UAH') . ')'
?>

<li id="cart" class="dropdown">
    <?= Html::a(FA::icon('shopping-cart') . ' ' . Yii::t('app', 'Cart') . ' ' . $amount, ['/cart/index'], ['class' => 'dropdown-toggle link']) ?>
    <div class="cart-block">
        <div class="details">
            <div><?= Yii::t('cart', 'Amount: ') ?><span class="count"><?= $count ?></span> шт.</div>
        </div>
        <div class="clearfix"></div>
    </div>
</li>