<?php
session_start();
include 'config.php';

if (isset($_POST['cart_id'], $_POST['quantity'])) {
    $cartId = $_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];

    if ($quantity > 0) {
        $updateQuery = "UPDATE cart SET quantity = $quantity WHERE cart_id = $cartId";
        if ($conn->query($updateQuery)) {
            echo "Cart updated successfully.";
        } else {
            echo "Error updating cart.";
        }
    } else {
        echo "Quantity must be at least 1.";
    }
}

header('Location: cart.php');
exit;
?>
