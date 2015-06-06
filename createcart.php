<?php

require ('include/cart_class.php');
session_start();
//$_SESSION['cart'] = "";
$cart = new Cart();
if (isset($_SESSION['cart'])) {
    $cart->load($_SESSION['cart']);
} else {
    $cart->setSessionName('cart');
    $cart->save();
}
