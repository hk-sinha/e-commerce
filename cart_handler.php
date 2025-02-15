<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "deno");
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

$product_id = $data['product_id'];
$quantity = $data['quantity'];
$action = $data['action'];

if ($action === 'add_to_cart') {
    // Check if product already exists in the cart
    $query = "SELECT * FROM cart WHERE product_id = $product_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Update quantity
        $updateQuery = "UPDATE cart SET quantity = quantity + $quantity WHERE product_id = $product_id";
        if ($conn->query($updateQuery)) {
            echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
    } else {
        // Insert new item
        $insertQuery = "INSERT INTO cart (product_id, quantity) VALUES ($product_id, $quantity)";
        if ($conn->query($insertQuery)) {
            echo json_encode(['success' => true, 'message' => 'Added to cart successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add to cart']);
        }
    }
} elseif ($action === 'buy_now') {
    // Insert order
    $orderQuery = "INSERT INTO orders (product_id, quantity, status) VALUES ($product_id, $quantity, 'Pending')";
    if ($conn->query($orderQuery)) {
        echo json_encode(['success' => true, 'message' => 'Order placed successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to place order']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}

$conn->close();
?>
