<?php
session_start();
include 'config.php';

$userid = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

if (!$userid) {
    echo "You must be logged in to proceed.";
    exit;
}
$userid = intval($_SESSION['user_id']);
$cart_items = [];

// Handle single product checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    $product_img = htmlspecialchars($_POST['product_img']);

    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $cart_items[] = [
            'product_id' => $product_id,
            'product_name' => $row['product_name'],
            'product_img' => $product_img,
            'price' => $row['price'],
            'quantity' => $quantity,
            'total' => $row['price'] * $quantity,
        ];
    }
}

// Handle cart checkout
if (!isset($_SESSION['user_id'])) {
    echo "Error: User not logged in.";
    exit;
}

$userid = $_SESSION['user_id']; // User ID from session
$cart_items = [];

// Fetch cart items for the logged-in user
$sql1 = "SELECT c.*, p.product_name, p.price, p.product_img_main 
        FROM cart c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = $userid";

$result1 = $conn->query($sql1);
if ($result1 && $result1->num_rows > 0) {
    while ($row1 = $result1->fetch_assoc()) {
        $row1['total'] = $row1['price'] * $row1['quantity'];
        $cart_items[] = $row1;
    }
}

if (empty($cart_items)) {
    echo "No items to checkout.";
    exit;
}
$grand_total = 0; // Initialize the grand total
foreach ($cart_items as $item) {
    $grand_total += $item['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="checkout.css">
</head>
<body>
<header>
    <!-- Your header content -->
</header>

<div class="checkout-container">
    <h1>Checkout</h1>
    <form action="place_order.php" method="post">
        <table class="checkout-table">
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><img src="admin/image/<?php echo $item['product_img_main']; ?>" alt="<?php echo $item['product_name']; ?>"></td>
                        <td><?php echo $item['product_name']; ?></td>
                        <td>Rs. <?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>Rs. <?php echo number_format($item['total'], 2); ?></td>
                    </tr>
                    <input type="hidden" name="product_id[]" value="<?php echo $item['product_id']; ?>">
        <input type="hidden" name="quantity[]" value="<?php echo $item['quantity']; ?>">
        <input type="hidden" name="price[]" value="<?php echo $item['price']; ?>">
                    <input type="hidden" name="cart_items[]" value='<?php echo json_encode($item); ?>'>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="checkout-summary">
            <h2>Grand Total: Rs. <?php echo number_format($grand_total, 2); ?></h2>
        </div>
        <input type="hidden" name="user_id" value="<?php echo $userid; ?>">
        <div class="shipping-details">
            <h2>Shipping Address</h2>
            <label for="address">Address:</label>
            <textarea name="address" id="address" required></textarea>
        </div>

        <button type="submit" >Place Order</button>
    </form>
</div>
</body>
</html>
