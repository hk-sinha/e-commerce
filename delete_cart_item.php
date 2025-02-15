<?php
session_start();
include 'config.php';

if (isset($_POST['cart_id'])) {
    $cartId = $_POST['cart_id'];
    $deleteQuery = "DELETE FROM cart WHERE cart_id = $cartId";
    if ($conn->query($deleteQuery)) {
        echo "Item removed from cart.";
    } else {
        echo "Error removing item.";
    }
}

header('Location: cart.php');
exit;
?>
