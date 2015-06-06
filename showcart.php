<?php
require ('include/cart_class.php');
session_start();

// Get Cart from Session
$cart = new Cart();

if (isset($_SESSION['cart'])) {
    $cart->load($_SESSION['cart']);
}
?><table border="1" >
    <tr>
        <th>Product ID</th>
        <th>QTY</th>
    </tr>
    <?php
    $products = $cart->getArray();
    foreach ($products as $key => $product) {
        echo '<tr>';
        echo '<td>' . $product->productId . '</td>';
        echo '<td>' . $product->qty . '</td>';
        echo '</tr>';
    }
    ?>

</table>