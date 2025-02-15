<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit;
    }

    $userid = intval($_SESSION['user_id']);
    $address = $conn->real_escape_string($_POST['address']);
    $order_date = date("Y-m-d H:i:s");

    // Ensure cart items are passed correctly
    if (!isset($_POST['product_id']) || !isset($_POST['quantity']) || !isset($_POST['price'])) {
        echo "Error: Invalid order data.";
        exit;
    }

    $product_ids = $_POST['product_id'];
    $quantities = $_POST['quantity'];
    $prices = $_POST['price'];

    if (count($product_ids) !== count($quantities) || count($product_ids) !== count($prices)) {
        echo "Error: Mismatched order details.";
        exit;
    }

    $conn->begin_transaction();
    try {
        foreach ($product_ids as $index => $product_id) {
            $product_id = intval($product_id);
            $quantity = intval($quantities[$index]);
            $price = floatval($prices[$index]);

            $sql = "INSERT INTO orders (user_id, product_id, quantity, price, delivery_address, order_date) 
                    VALUES ('$userid', '$product_id', '$quantity', '$price', '$address', '$order_date')";

            if (!$conn->query($sql)) {
                throw new Exception("Error inserting order: " . $conn->error);
            }
        }

        $conn->commit();
        echo "<p>Order placed successfully!</p>";
        echo "<a href='home.php'>Return to Home</a>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid access!";
}
?>
