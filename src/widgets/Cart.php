<?php

namespace app\widgets;

use yii\base\Widget;
use yz\shoppingcart\ShoppingCart;


class Cart extends Widget
{
    /**
     * @var ShoppingCart
     */
    protected $cart;

    public function init()
    {
        $this->cart = new ShoppingCart();
        parent::init();
    }

    public function run()
    {
        return $this->render('cart', [
            'count' => $this->cart->count,
            'cost' => $this->cart->cost,
        ]);
    }


}